<template>
    <div class="container">
        <div class="row justify-content-center">
            <h2>
                <template v-if="type == 'students/courses/'">
                    Assign courses to student {{ name }}
                </template>
                <template v-if="type == 'courses/students/'">
                    Assign students to course {{ name }}
                </template>
            </h2>

            <list-component :type="type + id" :key="keyIndex" mode="attach" @unassign="unassign"></list-component>

            <div v-if="dropdownData.length > 0" class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Assign
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a v-for="item in dropdownData" @click="assign(item.id)" class="dropdown-item" href="#">{{ item.name
                    }}</a>
                </div>
            </div>
            <h5 v-else>No data</h5>
        </div>

        <div class="row justify-content-center">
            <button @click="this.$emit('cancelAssign')" type="button" class="btn btn-secondary btn-sm mt-2">Cancel</button>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        type: String,
        id: {
            type: Number,
            default: null
        },
    },
    data() {
        return {
            name: "",
            dropdownId: null,
            dropdownData: [],
            keyIndex: 1,
        }
    },
    methods: {
        getData() {
            this.name = "";
            var link = this.type.split("/");
            axios.get('/api/' + link[0] + '/' + this.id)
                .then((response) => {
                    this.name = response.data.name;
                })
        },
        getDropdownData() {
            axios.get('/api/' + this.type + "unassigned/" + this.id)
                .then((response) => {
                    this.dropdownData = response.data;
                })
        },
        assign(assign_id) {
            var data = new FormData();
            data.append('id', this.id);
            data.append('assign_id', assign_id);
            axios.post('/api/' + this.type + 'assign', data)
                .then((response) => {
                    if (response.status == 200) {
                        this.keyIndex++;
                        this.getDropdownData()
                    }
                })
        },
        unassign(unassign_id) {
            var data = new FormData();
            data.append('id', this.id);
            data.append('unassign_id', unassign_id);
            axios.post('/api/' + this.type + 'unassign', data)
                .then((response) => {
                    if (response.status == 200) {
                        this.keyIndex++;
                        this.getDropdownData()
                    }
                })
        }
    },
    mounted() {
        this.getData()
        this.getDropdownData()
    }
}
</script>