<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        eTutor users
                    </span>
                    <div v-if="filterBy === 'tutee' && selectedTutees.length" tabindex="-2">
                        Assign tutors
                        <form>
                            <div class="form-row">
                                <div class="col-md-8">
                                    <select name="" class="form-control" id="" v-model="tutorToAssign">
                                        <option disabled value="">Select tutor</option>
                                        <option v-for="lec in systemTutors" :value="lec.uuid" :key="lec.uuid">{{ lec.name}} - {{ lec.email}}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success" @click.prevent="assignTuteeToTutor">Assign tutor</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="dropdown" tabindex="-1">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filter by role
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a @click.prevent="filterBy = 'staff'" class="dropdown-item" href="#">Staff</a>
                            <a @click.prevent="filterBy = 'tutor'" class="dropdown-item" href="#">Tutor</a>
                            <a @click.prevent="filterBy = 'tutee'" class="dropdown-item" href="#">Tutees</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Current Users -->
                <p class="mb-0" v-if="users.length === 0">
                    No users found
                </p>

                <table class="table table-bordered mb-0" v-if="users.length > 0">
                    <thead>
                        <tr>
                            <th v-if="filterBy === 'tutee'"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date created</th>
                            <th v-if="filterBy === 'tutor'"></th>
                            <th v-if="filterBy === 'tutee'"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="user in users">
                            <td v-if="filterBy === 'tutee'">
                                <input type="checkbox" class="form-check" name="user" :value="user.uuid" v-model="selectedTutees">
                            </td>

                            <!-- Name -->
                            <td style="vertical-align: middle;">
                                {{ user.name }}
                            </td>

                            <!-- Email -->
                            <td style="vertical-align: middle;">
                                {{ user.email }}
                            </td>

                            <!-- Role -->
                            <td style="vertical-align: middle;">
                                {{ user.role.name }}
                            </td>

                            <!-- Date created -->
                            <td style="vertical-align: middle;">
                                {{ user.created_at }}
                            </td>

                            <!-- View tutees -->
                            <td v-if="filterBy === 'tutor'" style="vertical-align: middle;">
                                <a class="action-link text-info" @click="tutees(user)">
                                    View tutees
                                </a>
                            </td>

                            <!-- View tutor -->
                            <td v-if="filterBy === 'tutee'" style="vertical-align: middle;">
                                <a class="action-link text-info" @click="tutors(user)">
                                    View tutor
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tutees modal -->
        <div class="modal fade" id="modal-user-tutees" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div v-if="selectedTutor" class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ selectedTutor.name }} tutees
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Tutees -->
                        <p class="mb-0" v-if="selectedTutor.tutees.length === 0">
                            No tutees found
                        </p>
                        <div class="list-group">
                            <div v-for="tutee in selectedTutor.tutees" :key="tutee.uuid"  class="list-group-item">
                                <div class="card-title">
                                    {{ tutee.user.name }}
                                </div>
                                <div class="card-subtitle">
                                    {{ tutee.user.email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tutor modal -->
        <div class="modal fade" id="modal-user-tutor" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div v-if="selectedTutor" class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ selectedTutor.name }} tutors
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Tutees -->
                        <p class="mb-0" v-if="selectedTutor.tutors.length === 0">
                            No tutors found
                        </p>
                        <div class="list-group">
                            <div class="list-group-item" v-for="tutor in selectedTutor.tutors" :key="tutor.uuid">
                                <div class="card-title">
                                    {{ tutor.tutor.name }}
                                </div>
                                <div class="card-subtitle">
                                    {{ tutor.tutor.email }}
                                </div>
                                <button class="btn btn-danger">remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Swal from 'sweetalert2';
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                filterBy: 'tutee',
                users: [],
                systemTutors: [],
                selectedTutor: undefined,
                selectedTutees: [],
                tutorToAssign: '',
                createForm: {
                    errors: [],
                    name: '',
                    email: '',
                    role: '',
                },
                editForm: {
                    errors: [],
                    name: '',
                    email: '',
                    role: '',
                }
            };
        },
        components: { Swal},

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getUsers();
                this.getTutors();
            },
            getUsers() {
                axios.get(`/staff/users-json?role=${this.filterBy}`)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            getTutors() {
                axios.get('/staff/users-json?role=tutor')
                    .then(response => {
                        this.systemTutors = response.data;
                    });
            },
            /**
             * Create a new tool.
             */
            store() {
                this.persistUser(
                    'post', '/staff/users',
                    this.createForm, '#modal-create-user'
                );
            },

            /**
             * Edit the given user.
             */
            edit(user) {
                this.editForm.uuid = user.uuid;
                this.editForm.name = user.name;
                this.editForm.email = user.email;

                $('#modal-edit-user').modal('show');
            },

            /**
             * Update the user being edited.
             */
            update() {
                this.persistUser(
                    'put', '/staff/users/' + this.editForm.uuid,
                    this.editForm, '#modal-edit-user'
                );
            },

            /**
             * Persist the user to storage using the given form.
             */
            persistUser(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        console.log(response.data);
                        this.getUsers();

                        form.name = '';
                        form.email = '';
                        form.role = '';
                        form.errors = [];

                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        console.log(error)
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given user.
             */
            destroy(user) {
                axios.delete(`/staff/users/${user.uuid}`)
                    .then(response => {
                        this.getUsers();
                    });
            },

            /**
             * Displays tutees for this user.
             */
            tutees(user) {
                this.selectedTutor = user;
                $('#modal-user-tutees').modal('show');
            },
            /**
             * Displays tutor for this user.
             */
            tutors(user) {
                this.selectedTutor = user;
                $('#modal-user-tutor').modal('show');
            },
            assignTuteeToTutor() {
                if (!this.tutorToAssign) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'You must select a tutor',
                        icon: 'error',
                        confirmButtonText: 'Close'
                    });
                    return;
                }

                const headers = {
                    'Content-Type': 'application/json',
                };
                const postData = { tutor: this.tutorToAssign, tutees: this.selectedTutees };
                axios.post('/staff/assign-tutor', postData, headers)
                    .then(response => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Tutor assigned successfully!',
                            icon: 'success',
                            confirmButtonText: 'Close'
                        });
                        this.selectedTutees = [];
                        this.getUsers();
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
        watch: {
            // whenever filterBy changes, this function will run
            filterBy: function (newFilterBy, oldFilterBy) {
                this.getUsers()
            }
        },
    }
</script>
