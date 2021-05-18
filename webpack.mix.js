const mix = require('laravel-mix');

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

mix.js('resources/js/main.js', 'public/js');
mix.styles(['resources/css/all.min.css', 'resources/css/style.css', 'node_modules/aos/dist/aos.css'], 'public/css/home.css')

mix.js('resources/js/user.js', 'public/js');
mix.styles(['resources/css/modern.css', 'resources/css/user.css'], 'public/css/user.css')