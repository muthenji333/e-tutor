/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('etutor-users', require('./components/admin/Users').default);
Vue.component('etutor-users-logs', require('./components/admin/UserLogs').default);
Vue.component('etutor-users-chats', require('./components/admin/UserChats').default);


Vue.component('staff-users', require('./components/staff/Users').default);

Vue.component('tutor-user-chats', require('./components/tutor/TutorUserChats').default);
Vue.component('user-tutor-chats', require('./components/tutee/UserTutorChats').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#content-wrapper',
});
