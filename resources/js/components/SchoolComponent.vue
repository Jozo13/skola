<template>
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button @click="selected = 'students'" type=" button" class="btn btn-secondary">Students</button>
                <button @click="selected = 'classes'" type=" button" class="btn btn-secondary">Courses</button>
                <button @click="selected = 'grades'" type=" button" class="btn btn-secondary">Grades</button>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <template v-if="selected == 'students'">
                <students-component></students-component>
            </template>
            <template v-if="selected == 'classes'">
                <courses-component></courses-component>
            </template>
            <template v-if="selected == 'grades'">
                <grades-component></grades-component>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selected: "students"
        }
    }
}
</script>
