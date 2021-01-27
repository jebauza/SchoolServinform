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

mix.styles(['resources/vendor/css/schoolservinform.css'], 'public/css/template.css')
    .js('resources/js/app.js', 'public/js') //JQuery, Bootstrap, VueJS
    .scripts(['resources/vendor/js/template.js'], 'public/js/template.js');