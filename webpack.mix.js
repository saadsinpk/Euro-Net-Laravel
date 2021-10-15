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


/* Combine CSS */
mix.combine([
    'public/assets/plugins/custom/datatables/datatables.bundle.css',
    // <!--begin::Page Vendor Stylesheets(used by this page)-->
    'public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css',
    // <!--begin::Global Stylesheets Bundle(used by all pages)-->
    'public/assets/plugins/global/plugins.bundle.css',
    'public/assets/css/style.bundle.css',
    'resources/scss/app.scss',

    // <!--end::Global Stylesheets Bundle-->

], 'public/css/app.css');

/* Combine JS */
// mix.combine([
//     // <!--begin::Global Javascript Bundle(used by all pages)-->
//     'public/assets/plugins/global/plugins.bundle.js',
//     // <!--end::Global Javascript Bundle-->
// ], 'public/js/app.js');