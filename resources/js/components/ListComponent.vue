<template>
    <div class="container">
        <div class="row justify-content-center mt-2">
            <ul>
                <li v-for="item in data" class="mb-2">
                    {{ item[name] }}

                    <template v-if="mode == 'attach'">
                        <template v-if="(type.split('/')[0]) == 'students'">
                            <div class=" dropdown d-inline-block">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <template v-if="!item.pivot.grade_id">
                                        Ungraded
                                    </template>
                                    <template v-if="showGrade(item.pivot.grade_id)">
                                        {{ showGrade(item.pivot.grade_id).name }} ({{
                                            showGrade(item.pivot.grade_id).value }})
                                    </template>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a v-for="grade in grades" @click="gradeCourse(item.id, grade.id)" class="dropdown-item"
                                        href="#">{{ grade.name }}
                                        ({{ grade.value }})</a>
                                </div>
                            </div>
                        </template>

                        <button @click="this.$emit('unassign', item.id)" type="button"
                            class="btn btn-info btn-sm ml-2">Unassign</button>
                    </template>
                    <template v-else>
                        <template v-if="type == 'grades'">({{ item[value] }})</template>
                        <button @click="this.$emit('editValue', item.id)" type="button"
                            class="btn btn-warning btn-sm ml-2">Edit</button>
                        <button @click="remove(item.id)" type="button" class="btn btn-danger btn-sm ml-2">Delete</button>
                        <button v-if="type != 'grades'" @click="this.$emit('assign', item.id)" type="button"
                            class="btn btn-info btn-sm ml-2">Assign</button>
                    </template>

                </li>
            </ul>
        </div>

        <div v-if="mode == 'attach'" class="row justify-content-center mt-2">
            <h3>Average grade: {{ averageGrade.toFixed(2) }}</h3>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        type: String,
        mode: {
            type: String,
            default: "normal"
        },
    },
    data() {
        return {
            data: [],
            name: "name",
            value: "value",
            grades: [],
            averageGrade: 0,
        }
    },
    methods: {
        getData() {
            axios.get('/api/' + this.type)
                .then((response) => {
                    this.data = response.data;

                    if (this.mode == 'attach' && (this.type.split('/')[0]) == 'students') {
                        var totalGrades = 0;
                        var length = 0;
                        this.data.forEach(item => {
                            var grade = this.showGrade(item.pivot.grade_id);
                            if (grade) {
                                totalGrades = totalGrades + grade.value;
                                length = length + 1;
                            }
                        })
                        this.averageGrade = totalGrades / length;
                    }
                })
        },
        remove(id) {
            var data = new FormData();
            data.append('id', id);
            axios.post('/api/' + this.type + '/delete', data)
                .then((response) => {
                    this.getData()
                })
        },
        getGrades() {
            axios.get('/api/grades')
                .then((response) => {
                    this.grades = response.data;
                })
        },
        showGrade(grade_id) {
            var index = this.grades.findIndex(function (sandwich) {
                if (sandwich.id === grade_id) {
                    return true;
                }
            });

            return this.grades[index];
        },
        gradeCourse(course_id, grade_id) {
            var link = this.type.split("/");
            var data = new FormData();
            data.append('course_id', course_id);
            data.append('grade_id', grade_id);
            data.append('student_id', link[2]);
            axios.post('/api/students/grade', data)
                .then((response) => {
                    this.getData()
                })
        }
    },
    mounted() {
        this.getGrades()
        this.getData()
    }
}
</script>
