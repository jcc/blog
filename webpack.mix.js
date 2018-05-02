const { mix } = require('laravel-mix');
const path = require('path');

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

mix.webpackConfig({
  output: {
    publicPath: "/",
    chunkFilename: 'js/[name].[chunkhash].js'
  },
  resolve: {
    alias: {
      'config': 'assets/js/config',
      'lang': 'assets/js/lang',
      'plugins': 'assets/js/plugins',
      'vendor': 'assets/js/vendor',
      'dashboard': 'assets/js/dashboard',
      'home': 'assets/js/home',
      'js': 'assets/js',
    },
    modules: [
      'node_modules',
      path.resolve(__dirname, "resources")
    ]
  },
});

let themes = [
  'resources/assets/sass/themes/default-theme.scss',
  'resources/assets/sass/themes/gray-theme.scss',
];

themes.forEach((item) => {
  mix.sass(item, 'public/css/themes').version();
})

mix.js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .js('resources/assets/js/home.js', 'public/js')
  .sass('resources/assets/sass/home.scss', 'public/css')
  .version();
