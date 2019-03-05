/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

import Vue from 'vue'
import httpPlugin from 'plugins/http/index'
import VueRouter from 'vue-router'
import store from './vuex/store.js'
import VueI18n from 'vue-i18n'
import 'vue-multiselect/dist/vue-multiselect.min.css'

import router from './router/index'
import locales from 'lang/index'

import App from './App.vue'

require('dashboard/runtime/mixins/index')

window.marked = require('marked')
window.hljs = require('vendor/highlight.min.js')
window.toastr = require('toastr/build/toastr.min.js')
window.innerHeight = 800

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
}

Vue.use(httpPlugin)
Vue.use(VueI18n)
Vue.use(VueRouter)

Vue.config.lang = window.Language

const i18n = new VueI18n({
    locale: Vue.config.lang,
    messages: locales
})

Vue.component('vue-table-pagination', require('dashboard/components/TablePagination.vue').default)

Vue.component('vue-table', require('dashboard/components/Table.vue').default)

Vue.component('vue-form', require('dashboard/components/Form.vue').default)

new Vue({
    router,
    store,
    i18n,
    render: (h) => h(App)
}).$mount('#app')
