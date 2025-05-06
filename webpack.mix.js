const mix = require('laravel-mix');
let ImageminPlugin = require( 'imagemin-webpack-plugin' ).default;


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')
    .postCss('resources/css/tailwind.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);


// Add near top of file


mix.webpackConfig( {
    plugins: [
        new ImageminPlugin( {
//            disable: process.env.NODE_ENV !== 'production', // Disable during development
            pngquant: {
                quality: '95-100',
            },
            test: /\.(jpe?g|png|gif|svg)$/i,
        } ),
    ],
} )

mix.sass('resources/sass/style.sass', 'public/web/');
mix.combine(['resources/css/web/all.css', 'resources/css/web/bootstrap.min.css',], 'public/web/vendor.css');
mix.combine(['resources/js/web/jquery-3.5.0.min.js', 'resources/js/web/bootstrap.min.js', 'resources/js/web/popper.min.js', 'resources/js/web/main.js'], 'public/web/main.js');
mix.copy('resources/images/', 'public/web/images/');
mix.copy('resources/webfonts/', 'public/webfonts/');

