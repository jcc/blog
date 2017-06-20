
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import httpPlugin from 'plugins/http';
import VueRouter from 'vue-router';
import store from './vuex/store.js';
import VueI18n from 'vue-i18n';
import 'vue-multiselect/dist/vue-multiselect.min.css';

import routes from './routes.js';
import locales from 'lang';

import App from './App.vue';

window.toastr = require('toastr/build/toastr.min.js');
window.innerHeight = 800;

window.toastr.options = {
    positionClass: "toast-bottom-right",
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
};

Vue.use(httpPlugin);
Vue.use(VueI18n);
Vue.use(VueRouter);

Vue.config.lang = window.Language;

const i18n = new VueI18n({
    locale: Vue.config.lang,
    messages: locales
})

Vue.component(
    'vue-table-pagination',
    require('components/dashboard/TablePagination.vue')
);

Vue.component(
    'vue-table',
    require('components/dashboard/Table.vue')
);

Vue.component(
    'vue-form',
    require('components/dashboard/Form.vue')
);

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    linkActiveClass: 'active',
    routes: routes
});

new Vue({
    router,
    store,
    i18n,
    render: h => h(App),
}).$mount('#app');
