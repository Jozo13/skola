<template>
    <div class="container">
        <div class="row justify-content-center">
            <h2>Students</h2>
            <template v-if="edit == false && assign == false">
                <button @click="add = !add" type="button" class="btn btn-success btn-sm ml-2">Add</button>

                <create-component v-if="add" type="students" @refresh-list="keyIndex++"></create-component>

                <list-component type="students" :key="keyIndex" @edit-value="showEdit"
                    @assign="assignClasses"></list-component>
            </template>
            <create-component v-if="edit == true" type="students" mode="edit" :id="id" @cancel-edit="edit = false"
                @refresh-list="keyIndex++"></create-component>
            <assign-component v-if="assign == true" type="students/courses/" :id="id"
                @cancel-assign="assign = false"></assign-component>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            add: false,
            keyIndex: 1,
            edit: false,
            id: null,
            assign: false,
        }
    },
    methods: {
        showEdit(id) {
            this.id = id;
            this.edit = true;
        },
        assignClasses(id) {
            this.id = id;
            this.assign = true;
        }
    }
}
</script>