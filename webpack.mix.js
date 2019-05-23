const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js').version();
mix.styles([
   'public/css/bootstrap.min.css',
   'public/css/animate.css',
   'public/css/font-awesome.min.css',
   'public/css/style.css',
   'public/css/responsive.css'
],'public/css/app.css').version();
