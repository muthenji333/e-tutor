<style scoped>
</style>

<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">
                    Tutors (select to chat)
                </div>

                <div class="card-body">
                    <!-- Current tutors -->
                    <p class="mb-0" v-if="mtutors.length === 0">
                        No tutors found
                    </p>

                    <div class="list-group">
                        <div class="list-group-item" v-for="tutor in mtutors" :key="tutor.uuid" @click="markTuteeSelected(tutor.tutor)" :class="selectedTutorUuid === tutor.tutor.uuid ? 'active': ''">
                            <div class="card-text">{{ tutor.tutor.name }}</div>
                            <div class="card-subtitle">{{ tutor.tutor.email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="chats" class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    Conversation
                </div>

                <div class="card-body">
                    <!-- Current tutors -->
                    <p class="mb-0" v-if="chats.length === 0">
                        No chats found
                    </p>

                    <div class="list-group">
                        <div class="list-group-item" v-for="chat in chats" :key="chat.uuid">
                            <div class="card-title">{{ chat.from_user.name }}</div>
                            <div class="card-text">{{ chat.message }}</div>
                            <div>
                                <a v-if="chat.attachment" :href="chat.attachment"><i class="fa fa-paperclip"></i> attachment</a>
                            </div>
                            <span>{{ chat.created_at }}</span>
                        </div>
                        <div class="list-group-item">
                            <textarea name="" id="" rows="4" v-model="createMessage.message" class="form-control">

                            </textarea>
                            <input type="file" class="form-control" id="fileCreate" ref="fileCreate"
                                   v-on:change="handleFileCreate" required>
                            <button type="button" class="btn btn-success" @click="sendMessage">Send</button>
                        </div>
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
                mtutors: [],
                selectedTutor: undefined,
                chats: undefined,
                selectedTutorUuid: '',
                createMessage: {
                    message: '',
                    resource: undefined,
                    errors: []
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
                this.getTutors();
            },
            getTutors() {
                axios.get('/tutee/users-json')
                    .then(response => {
                        this.mtutors = response.data;
                    });
            },
            getChats() {
                axios.get(`/tutee/chats/${this.selectedTutorUuid}`)
                    .then(response => {
                        this.chats = response.data;
                    });
            },
            markTuteeSelected(tutor) {
                this.selectedTutor = tutor;
                this.selectedTutorUuid = tutor.uuid;

                this.getChats();
            },
            /**
             * upload file
             */
            handleFileCreate() {
                this.createMessage.resource = this.$refs.fileCreate.files[0];
            },
            persistMessage(method, uri, form) {
                form.errors = [];

                var headers = {
                    'Content-Type': 'multipart/form-data'
                };

                let formData = new FormData();
                formData.append('message', form.message);
                formData.append('resource', form.resource);

                axios[method](uri, formData, { headers : headers })
                    .then(response => {
                        this.getChats();

                        form.message = '';
                        form.resource = '';
                        console.log(response.data)

                        if (!response.data.status) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred. Try again',
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                            return;
                        }

                        Swal.fire({
                            title: 'Success!',
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'Close'
                        });

                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Try again',
                            icon: 'error',
                            confirmButtonText: 'Close'
                        });
                    });
            },
            sendMessage() {
                this.persistMessage(
                    'post', `/tutee/chats/${this.selectedTutorUuid}`,
                    this.createMessage
                );
            },
        }
    }
</script>
