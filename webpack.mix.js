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

mix.sass('public/assets/css/custom.scss', 'public/assets/css/custom.css');

mix.scripts([
    'public/assets/js/jquery-3.6.0.min.js',
    'public/assets/js/jquery.rateit.min.js',
    'public/assets/js/bootstrap-4.6.0.min.js',
    'public/assets/js/hc-offcanvas-menu.min.js',
    'public/assets/js/wow.js',
    'public/assets/js/swiper.min.js',
    'public/assets/js/toast.min.js',
    'public/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js',
    'public/adminLTE/bower_components/datatables.net/js/dataTables.bootstrap.min.js',
    'public/assets/js/custom.js'
], 'public/assets/js/app.js');

mix.styles([
    'public/assets/css/bootstrap-4.6.0.min.css',
    'public/assets/css/bootstrap-icons.css',
    'public/assets/css/hc-offcanvas-menu.min.css',
    'public/assets/css/animate.css',
    'public/assets/css/swiper.min.css',
    'public/assets/css/toast.min.css',
    'public/assets/css/rateit.css',
    'public/adminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
    'public/assets/css/custom.css'
], 'public/assets/css/app.css');
