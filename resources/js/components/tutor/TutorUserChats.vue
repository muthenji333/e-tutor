<style scoped>
</style>

<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">
                    Tutees (select to chat)
                </div>

                <div class="card-body">
                    <!-- Current tutees -->
                    <p class="mb-0" v-if="tutees.length === 0">
                        No tutees found
                    </p>

                    <div class="list-group">
                        <div class="list-group-item" v-for="tutee in tutees" :key="tutee.uuid" @click="markTuteeSelected(tutee.user)" :class="selectedTuteeUuid === tutee.user.uuid ? 'active': ''">
                            <div class="card-text">{{ tutee.user.name }}</div>
                            <div class="card-subtitle">{{ tutee.user.email }}</div>
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
                    <!-- Current tutees -->
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
                tutees: [],
                selectedTutee: undefined,
                chats: undefined,
                selectedTuteeUuid: '',
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
                this.getTutees();
            },
            getTutees() {
                axios.get('/tutor/users-json')
                    .then(response => {
                        this.tutees = response.data;
                    });
            },
            getChats() {
                axios.get(`/tutor/chats/${this.selectedTuteeUuid}`)
                    .then(response => {
                        this.chats = response.data;
                    });
            },
            markTuteeSelected(tutee) {
                this.selectedTutee = tutee;
                this.selectedTuteeUuid = tutee.uuid;

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
                    'post', `/tutor/chats/${this.selectedTuteeUuid}`,
                    this.createMessage
                );
            },
        }
    }
</script>
