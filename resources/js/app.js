require('./bootstrap');

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import moment from 'moment'

import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

window.Vue = require('vue').default;
window.$ = window.jQuery = require('jquery');

Vue.component('link-component', require('./components/LinkComponent.vue').default);
Vue.component('create-component', require('./components/CreateComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'))

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(value).fromNow()
    }
})

const app = new Vue({
    el: '#app',
});