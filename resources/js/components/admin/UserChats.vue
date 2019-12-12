<style scoped>
</style>

<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">
                    Select tutor
                </div>

                <div class="card-body">
                    <!-- Current tutors -->
                    <p class="mb-0" v-if="tutors.length === 0">
                        No tutors found
                    </p>

                    <div class="list-group">
                        <div class="list-group-item" v-for="tutor in tutors" :key="tutor.uuid" @click="markTutorSelected(tutor)" :class="selectedTutorUuid === tutor.uuid ? 'active': ''">
                            <div class="card-text">{{ tutor.name }}</div>
                            <div class="card-subtitle">{{ tutor.email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="chats" class="col-md-4">
            <div class="card card-default">
                <div class="card-header">
                    Select tutee to view conversation
                </div>

                <div class="card-body">
                    <!-- Current tutees -->
                    <p class="mb-0" v-if="selectedTutor.tutees.length === 0">
                        No tutees found
                    </p>

                    <div class="list-group">
                        <div class="list-group-item" v-for="tutee in selectedTutor.tutees" :key="tutee.uuid" @click="markTuteeSelected(tutee.user)" :class="selectedTuteeUuid === tutee.user.uuid ? 'active': ''">
                            <div class="card-text">{{ tutee.user.name }}</div>
                            <div class="card-subtitle">{{ tutee.user.email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="chats" class="col-md-4">
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
                tutors: [],
                selectedTutor: undefined,
                selectedTutee: undefined,
                chats: undefined,
                selectedTutorUuid: '',
                selectedTuteeUuid: ''
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
                this.getTutors();
            },
            getTutors() {
                axios.get('/admin/users-json?role=tutor')
                    .then(response => {
                        this.tutors = response.data;
                    });
            },
            getChats() {
                axios.get(`/admin/chats-json/${this.selectedTuteeUuid}/${this.selectedTutorUuid}`)
                    .then(response => {
                        this.chats = response.data;
                    });
            },
            markTutorSelected(tutor) {
                this.selectedTutor = tutor;
                this.selectedTutorUuid = tutor.uuid;
                this.chats = [];
            },
            markTuteeSelected(tutee) {
                this.selectedTutee = tutee;
                this.selectedTuteeUuid = tutee.uuid;

                this.getChats();
            }
        }
    }
</script>
