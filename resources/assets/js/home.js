window.$ = window.jQuery = require('jquery');
window.swal = require('sweetalert');
window.Vue = require('vue');

import VueI18n from 'vue-i18n';
import locales from './lang';

require('bootstrap-sass');
require('vue-resource');
require('social-share.js/dist/js/social-share.min.js');
require('./vendor/select2.min.js');
window.marked = require('marked');
window.hljs = require('./vendor/highlight.min.js');

Vue.use(VueI18n);

Vue.config.lang = window.Language;

const i18n = new VueI18n({
    locale: Vue.config.lang,
    messages: locales
})

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});

Vue.component('comment', require('./components/Comment.vue'));

Vue.component('jumbotron', require('./components/Jumbotron.vue'));

Vue.component('parse', require('./components/Parse.vue'));

Vue.component('avatar', require('./components/AvatarUpload.vue'));

new Vue({
    i18n: i18n,
}).$mount('#app');