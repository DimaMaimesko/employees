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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/jstree/dist/jstree.js',
],  'public/js/jstree.js').version();
mix.styles([
    'node_modules/jstree/dist/themes/default/style.css',
], 'public/css/jstree.css').version();