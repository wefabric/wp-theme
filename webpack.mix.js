const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')

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
mix.setPublicPath('dist');

mix.js('assets/js/app.js', 'dist/js')
    .sass('assets/sass/app.scss', 'dist/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .copyDirectory('node_modules/@fortawesome/fontawesome-pro/webfonts', 'dist/fonts');


if (mix.inProduction()) {
    mix.version();
}
