window.$ = window.jQuery = require('jquery');
window.swal = require('sweetalert');
window.Vue = require('vue');

import VueI18n from 'vue-i18n';
import locales from 'lang';
import httpPlugin from 'plugins/http';

require('bootstrap-sass');
require('social-share.js/dist/js/social-share.min.js');
require('vendor/select2.min.js');
window.marked = require('marked');
window.hljs = require('vendor/highlight.min.js');
window.toastr = require('toastr/build/toastr.min.js');

Vue.use(VueI18n);
Vue.use(httpPlugin);

Vue.config.lang = window.Language;

const i18n = new VueI18n({
    locale: Vue.config.lang,
    messages: locales
})

Vue.component('comment', require('components/Comment.vue'));

Vue.component('parse', require('components/Parse.vue'));

Vue.component('parse-textarea', require('components/Textarea.vue'));

Vue.component('avatar', require('components/AvatarUpload.vue'));

new Vue({
    i18n: i18n,
}).$mount('#app');