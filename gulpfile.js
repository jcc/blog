const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {

    mix.sass('app.scss')
        .webpack('app.js');

    mix.sass('home.scss')
        .webpack('home.js');

    mix.sass([
        'vendor/jcrop.min.css'
    ], 'public/css/jcrop.css');

    mix.scripts([
        'vendor/jcrop.min.js',
        'vendor/jquery.form.min.js'
    ], 'public/js/jcrop.js');

    mix.version([
        'public/css/app.css',
        'public/css/home.css',
        'public/css/jcrop.css',
        'public/js/app.js',
        'public/js/home.js',
        'public/js/jcrop.js'
    ]);

});
