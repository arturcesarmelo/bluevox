import router from './router.js';
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import swal from 'sweetalert';
import Toastr from 'vue-toastr';

Vue.component('vue-toastr',Toastr);
Vue.use(VueRouter)
const app = new Vue({
    el: '#app',
    router
});
