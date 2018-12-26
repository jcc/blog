const {mix} = require('laravel-mix');
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
let config = {
    resolve: {
        alias: {
            'config': 'js/config',
            'lang': 'js/lang',
            'plugins': 'js/plugins',
            'vendor': 'js/vendor',
            'dashboard': 'js/dashboard',
            'home': 'js/home',
            'js': 'js',
        },
        modules: [
            'node_modules',
            path.resolve(__dirname, "resources")
        ]
    },
}

if (!process.argv.includes('--hot')) {
    config = Object.assign(config, {
        output: {
            publicPath: "/",
            chunkFilename: 'js/[name].[chunkhash].js'
        }
    })
}

mix.webpackConfig(config)

let themes = [
    'resources/sass/themes/default-theme.scss',
    'resources/sass/themes/gray-theme.scss',
];

themes.forEach((item) => {
    mix.sass(item, 'public/css/themes')
})

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/home.js', 'public/js')
    .sass('resources/sass/home.scss', 'public/css')
    // .js('resources/js/vendor/jquery-3.3.1.min.js', 'public/js')
    // .js('resources/js/vendor/imagesloaded.min.js', 'public/js')
    // .js('resources/js/vendor/masonry.js', 'public/js')

if (mix.inProduction()) {
    mix.version()
    mix.webpackConfig({
        plugins: [
            new OptimizeCSSPlugin({
                cssProcessorOptions: {
                    safe: true,
                    discardComments: {
                        removeAll: true
                    }
                }
            })
        ]
    });
    mix.options({
        uglify: {
            uglifyOptions: {
                sourceMap: false, // 关闭资源映射
                compress: {
                    warnings: false,
                    drop_console: true // 去除控制台输出代码
                },
                output: {
                    comments: false // 去除所有注释
                }
            }
        }
    });

}
