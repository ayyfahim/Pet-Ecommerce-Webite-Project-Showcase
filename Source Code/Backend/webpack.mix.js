const mix = require("laravel-mix");
const WebpackRTLPlugin = require("webpack-rtl-plugin");

// Front End (React)
mix.sass("resources/react/styles/style.scss", "public/assets/front/css").webpackConfig({
    plugins: [new WebpackRTLPlugin({ minify: true })]
});
mix.react("resources/react/index.jsx", "public/assets/front/js");
// mix.browserSync("localhost:8000");
// mix.styles([
//     'resources/assets/admin/assets/vendors/css/vendors.min.css',
//     'resources/assets/admin/assets/vendors/css/forms/select/select2.min.css',
//     'resources/assets/admin/assets/css/bootstrap.css',
//     'resources/assets/admin/assets/css/bootstrap-extended.css',
//     'resources/assets/admin/assets/vendors/css/pickers/flatpickr/flatpickr.min.css',
//     'resources/assets/admin/assets/css/plugins/forms/pickers/form-flat-pickr.css',
//     'resources/assets/admin/assets/css/colors.css',
//     'resources/assets/admin/assets/css/components.css',
//     'resources/assets/admin/assets/css/core/menu/menu-types/vertical-menu.css',
//     'resources/assets/admin/assets/css/style.css',
// ], 'public/assets/admin/css/app.css');
//
// mix.scripts([
//     'resources/assets/admin/assets/vendors/js/vendors.min.js',
//     'resources/assets/admin/assets/vendors/js/forms/select/select2.full.min.js',
//     'resources/assets/admin/assets/js/scripts/forms/form-select2.js',
//     'resources/assets/admin/assets/vendors/js/pickers/flatpickr/flatpickr.min.js',
//     'resources/assets/admin/assets/js/scripts/forms/pickers/form-pickers.js',
//     'resources/assets/admin/assets/js/core/app-menu.js',
//     'resources/assets/admin/assets/js/core/app.js',
//     'resources/assets/admin/assets/js/custom.js',
//     'resources/assets/admin/assets/js/ajax.js',
// ], 'public/assets/admin/js/app.js');
