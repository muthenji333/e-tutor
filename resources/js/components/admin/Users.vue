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
                    <div class="dropdown" tabindex="-2">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filter by role
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a @click.prevent="filterBy = 'all'" class="dropdown-item" href="#">All</a>
                            <a @click.prevent="filterBy = 'admin'" class="dropdown-item" href="#">Admin</a>
                            <a @click.prevent="filterBy = 'staff'" class="dropdown-item" href="#">Staff</a>
                            <a @click.prevent="filterBy = 'tutor'" class="dropdown-item" href="#">Tutor</a>
                            <a @click.prevent="filterBy = 'tutee'" class="dropdown-item" href="#">Tutees</a>
                        </div>
                    </div>

                    <a class="action-link" tabindex="-1" @click="showCreateUserForm">
                        Add New User <i class="fa fa-plus-square"></i>
                    </a>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date created</th>
                            <th v-if="filterBy === 'tutor'"></th>
                            <th v-if="filterBy === 'tutee'"></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="user in users">

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
                                <a class="action-link text-info" @click.prevent="tutees(user)">
                                    View tutees
                                </a>
                            </td>

                            <!-- View tutor -->
                            <td v-if="filterBy === 'tutee'" style="vertical-align: middle;">
                                <a class="action-link text-info" @click.prevent="tutors(user)">
                                    View tutor
                                </a>
                            </td>

                            <!-- Edit Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link" tabindex="-1" @click.prevent="edit(user)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link text-danger" @click.prevent="destroy(user)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Tool Modal -->
        <div class="modal fade" id="modal-create-user"  tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create User
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create User Form -->
                        <form role="form">
                            <!-- Disorder -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Disorder</label>

                                <div class="col-md-9">
                                    <select name="staff" id="staff" class="form-control" v-model="createForm.role" required>
                                        <option value="">Select Role</option>
                                        <option v-for="role in roles" :key="role.uuid" v-bind:value="role.uuid">{{ role.name }}</option>
                                    </select>

                                    <span class="form-text text-muted">
                                        Role of the user
                                    </span>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="create-user-name" type="text" class="form-control"
                                           v-model="createForm.name" required>

                                    <span class="form-text text-muted">
                                        User's name
                                    </span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email</label>

                                <div class="col-md-9">
                                    <input id="create-user-email" type="text" class="form-control"
                                           v-model="createForm.email" required>

                                    <span class="form-text text-muted">
                                        Email
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal" id="modal-edit-user" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit user
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit User Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="edit-user-name" type="text" class="form-control"
                                           v-model="editForm.name">

                                    <span class="form-text text-muted">
                                        Name of the user
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email</label>
                                <div class="col-md-9">
                                    <input id="edit-user-email" type="text" class="form-control"
                                           v-model="editForm.email">

                                    <span class="form-text text-muted">
                                            Email of the user
                                        </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
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
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                filterBy: 'all',
                users: [],
                roles: [],
                selectedTutor: undefined,
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
                this.getRoles();

                $('#modal-create-user').on('shown.bs.modal', () => {
                    $('#create-user-name').focus();
                });

                $('#modal-edit-user').on('shown.bs.modal', () => {
                    $('#edit-user-name').focus();
                });
            },
            getUsers() {
                axios.get(`/admin/users-json?role=${this.filterBy}`)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            /**
             * Get all system roles.
             */
            getRoles() {
                axios.get('/admin/roles-json')
                    .then(response => {
                        this.roles = response.data;
                    });
            },
            /**
             * Show the form for creating new usr.
             */
            showCreateUserForm() {
                $('#modal-create-user').modal('show');
            },
            /**
             * Create a new tool.
             */
            store() {
                this.persistUser(
                    'post', '/admin/users',
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
                    'put', '/admin/users/' + this.editForm.uuid,
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
                axios.delete(`/admin/users/${user.uuid}`)
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
        },
        watch: {
            // whenever filterBy changes, this function will run
            filterBy: function (newFilterBy, oldFilterBy) {
                this.getUsers()
            }
        },
    }
</script>
