<template>
    <div class="container">
        <div class="row justify-content-center">
            <h2>Grades</h2>
            <template v-if="edit == false">
                <button @click="add = !add" type="button" class="btn btn-success ml-2">Add</button>

                <create-component v-if="add" type="grades" @refresh-list="keyIndex++"></create-component>

                <list-component type="grades" :key="keyIndex" @edit-value="showEdit"></list-component>
            </template>
            <create-component v-else type="grades" mode="edit" :id="editId" @cancel-edit="edit = false"
                @refresh-list="keyIndex++"></create-component>
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
            editId: null,
        }
    },
    methods: {
        showEdit(data) {
            this.editId = data;
            this.edit = true;
        }
    }
}
</script>
