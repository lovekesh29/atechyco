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


//this is for main site
mix.js(['resources/js/main.js'], 'public/js/main.js');
mix.styles(['resources/css/all.min.css', 'node_modules/intl-tel-input/build/css/intlTelInput.min.css', 'resources/css/style.css', 'node_modules/aos/dist/aos.css'], 'public/css/home.css')

//this is for user pannel site
mix.js(['resources/js/dashboard-template.js', 'resources/js/user.js'], 'public/js/user.js');
mix.js('resources/js/userTop.js', 'public/js');
mix.styles(['resources/css/modern.css', 'node_modules/intl-tel-input/build/css/intlTelInput.min.css', 'resources/css/user.css'], 'public/css/user.css');

//this is for guru pannel site
mix.js(['resources/js/dashboard-template.js', 'resources/js/guru.js'], 'public/js/guru.js');
mix.js('resources/js/guruTop.js', 'public/js');
mix.styles(['resources/css/modern.css', 'node_modules/intl-tel-input/build/css/intlTelInput.min.css', 'resources/css/guru.css'], 'public/css/guru.css');



//this is for admin pannel site
mix.styles(['resources/css/modern-admin.css', 'node_modules/intl-tel-input/build/css/intlTelInput.min.css', 'resources/css/admin.css'], 'public/css/admin.css');
mix.js('resources/js/adminTop.js', 'public/js');
mix.js(['resources/js/dashboard-template.js', 'resources/js/admin.js'], 'public/js/admin.js');