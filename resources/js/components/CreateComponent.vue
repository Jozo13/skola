<template>
    <div class="container">
        <div class="row justify-content-center">
            <h2>Add {{ type }}</h2>

            <div v-if="type == 'grades'" class="input-group mb-3">
                <input v-model="value" @change="isNumber()" type="number" class="form-control"
                    :placeholder="type + ' number'" :aria-label="type + ' number'" aria-describedby="basic-addon2">
            </div>

            <div class="input-group mb-3">
                <input v-model="name" type="text" class="form-control" :placeholder="type + ' name'"
                    :aria-label="type + ' name'" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button v-if="mode == 'create'" @click="create()" class="btn btn-success" type="button">Add</button>
                    <button v-if="mode == 'edit'" @click="edit()" class="btn btn-success" type="button">Edit</button>
                </div>
            </div>

            <button v-if="mode == 'edit'" @click="this.$emit('cancelEdit')" type="button"
                class="btn btn-secondary btn-sm mt-2">Cancel</button>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        type: String,
        mode: {
            type: String,
            default: "create"
        },
        id: {
            type: Number,
            default: null
        },
    },
    data() {
        return {
            name: "",
            value: 1,
        }
    },
    methods: {
        create() {
            var data = new FormData();
            data.append('name', this.name);
            data.append('value', this.value);
            axios.post('/api/' + this.type + '/create', data)
                .then((response) => {
                    this.$emit('refreshList')
                    this.name = "";
                })
        },
        edit() {
            var data = new FormData();
            data.append('id', this.id);
            data.append('name', this.name);
            data.append('value', this.value);
            axios.post('/api/' + this.type + '/edit', data)
                .then((response) => {
                    if (response.status == 200) {
                        this.$emit('cancelEdit')
                        this.$emit('refreshList')
                    }
                })
        },
        isNumber() {
            var grades = [1, 2, 3, 4, 5];
            if (grades.indexOf(this.value) == -1) {
                this.value = 1;
            }

        },
        getData() {
            this.name = "";
            this.value = 1;
            axios.get('/api/' + this.type + '/' + this.id)
                .then((response) => {
                    this.name = response.data.name;
                    this.value = response.data.value;
                })
        }
    },
    mounted() {
        if (this.mode == "edit") {
            this.getData();
        }
    }
}
</script>