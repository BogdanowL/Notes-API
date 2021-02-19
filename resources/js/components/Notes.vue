<template>
<div>
    <h1>Все записи</h1>
    <div class="row">
        <div class="col-sm-6">
            <validation-errors v-if="validationErrors"
                               :errors="validationErrors"
            >
            </validation-errors>
            <form @submit.prevent="addNote()" class="mb-4">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input v-model="note.title" type="text" name="title" class="form-control" id="title" >
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea v-model="note.description" class="form-control" name="description" id="description" rows="3"></textarea>
                </div>
                <button v-if="edit === false" type="submit" class="btn btn-primary">Сохранить</button>
                <button v-else type="submit" class="btn btn-success">Сохранить Изменения</button>
            </form>
        </div>
    </div>
    <div v-if="errored" class="alert alert-danger" role="alert">
        Записи не загрузились :(
    </div>
<div class="col-md-12">
    <div class="row">
        <div v-if="loading"><h1>Загрузка...</h1> </div>

        <table class="table" v-else>
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Описание</th>
                <th scope="col">Операции</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="note  in notes" :key="note.id">
                <th >{{note.id}}</th>
                <td>{{note.title}}</td>
                <td>{{note.description.substr(0, 80) + '...'}}</td>
                <td>
                    <div class="d-inline-block">
                        <button @click="editNote(note)" class="btn btn-success mt-2">
                            <i class="fas fa-pencil-alt" ></i>
                        </button>
                        <button @click="deleteNote(note.id)" class="btn btn-danger mt-2">
                            <i class="far fa-times-circle" ></i>
                        </button>
                    </div>

                </td>
            </tr>

            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li :class="{disabled: ! pagination.prev_page_url}" class="page-item"
                    @click.prevent="getNotes(pagination.prev_page_url)"
                >
                    <a class="page-link" href="#">Назад</a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link" href="#">Страница {{ pagination.current_page }} из {{ pagination.last_page }}</a>
                </li>


                <li :class="{disabled: ! pagination.next_page_url}" class="page-item"
                    @click.prevent="getNotes(pagination.next_page_url)" >
                    <a class="page-link" href="#">Следующая</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

</div>

</template>

<script>
    export default {
        data() {
            return {
                notes: [],
                note: {
                    id: '',
                    title: '',
                    description: ''
                },
                pagination: {},
                token: '',
                edit: false,
                loading: true,
                errored: false,
                validationErrors: ''

            }
        },
        mounted() {
            this.getNotes()
        },
        methods: {
            getNotes(page_url) {
                page_url = page_url || '/api/notes'

                axios
                    .get(page_url)
                    .then(response => {
                        this.notes = response.data.data
                        this.makePagination(response.data)
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true;
                    })
                    .finally(() => this.loading = false)
            },
            makePagination(response) {
                let pagination = {
                    current_page: response.current_page,
                    last_page: response.last_page,
                    prev_page_url: response.prev_page_url,
                    next_page_url: response.next_page_url,
                }

                this.pagination = pagination
            },
            deleteNote(id) {

                axios
                    .delete(`/api/notes/${id}`)
                    .then(response => {
                        this.getNotes()
                    })
                    .catch(error => console.log(error))
            },
            addNote() {
                if (this.edit === false) {
                    // Add Note
                    axios
                        .post('/api/notes', {
                            title: this.note.title,
                            description: this.note.description
                        })
                        .then(response => {
                            this.note.title = ''
                            this.note.description = ''
                            this.getNotes()

                        })
                        .catch(error => {
                            if (error.response.status === 422)
                            {
                                this.validationErrors = error.response.data.errors
                            }
                            console.log(error)
                        })
                }else{
                    // Edit Note
                    axios
                        .put(`/api/notes/${this.note.id}`, {
                            title: this.note.title,
                            description: this.note.description
                        })
                        .then(response => {
                            this.note.title = ''
                            this.note.description = ''
                            this.getNotes()
                        })
                        .catch(error => {
                            if (error.response.status === 422)
                            {
                                this.validationErrors = error.response.data.errors
                            }
                            console.log(error)
                        })
                        .finally(() => this.edit = false);
                }
            },

            editNote(note){
                this.edit = true
                this.note.id = note.id
                this.note.title = note.title
                this.note.description = note.description
            }
        }
    }
</script>

<style scoped>

</style>
