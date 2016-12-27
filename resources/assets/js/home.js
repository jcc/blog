window.$ = window.jQuery = require('jquery');
window.swal = require('sweetalert');
window.Vue = require('vue');

require('bootstrap-sass');
require('vue-resource');
require('social-share.js/dist/js/social-share.min.js');
require('./vendor/select2.min.js');
window.marked = require('marked');
window.hljs = require('./vendor/highlight.min.js');

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});

Vue.component('comment', require('./components/Comment.vue'));

Vue.component('jumbotron', require('./components/Jumbotron.vue'));

Vue.component('parse', require('./components/Parse.vue'));

new Vue({
    el: '#app'
});