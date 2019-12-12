<style scoped>
</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        eTutor users logs
                    </span>
                </div>
            </div>

            <div class="card-body">
                <!-- Current Users logs -->
                <p class="mb-0" v-if="userLogs.length === 0">
                    No logs found
                </p>

                <table class="table table-bordered mb-0" v-if="userLogs.length > 0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Task</th>
                            <th>Date created</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="userLog in userLogs">

                            <!-- Name -->
                            <td style="vertical-align: middle;">
                                {{ userLog.user.name }}
                            </td>

                            <!-- Email -->
                            <td style="vertical-align: middle;">
                                {{ userLog.user.email }}
                            </td>

                            <!-- Task -->
                            <td style="vertical-align: middle;">
                                {{ userLog.task }}
                            </td>

                            <!-- Date created -->
                            <td style="vertical-align: middle;">
                                {{ userLog.created_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                userLogs: []
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
                this.getUserLogs();
            },
            getUserLogs() {
                axios.get('/admin/users-logs-json')
                    .then(response => {
                        this.userLogs = response.data;
                    });
            }
        }
    }
</script>
