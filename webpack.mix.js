const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .js('resources/assets/js/home.js', 'public/js')
   .sass('resources/assets/sass/home.scss', 'public/css')
   .version();

mix.combine([
    'vendor/jcrop.min.css'
], 'public/css/jcrop.css').version();

mix.js('resources/assets/js/vendor/combine.js', 'public/js/jcrop.js').version();
