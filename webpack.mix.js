const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const postcss = require('postcss');
const {copyDirectory} = require("laravel-mix");

// Wraps Tailwind hover utilities in @media (hover: hover) so touch devices
// don't show hover states on first tap before navigating.
// Collects all matching rules first, then wraps — avoids tree-mutation issues during walk.
const hoverMediaQueryPlugin = (css) => {
    const rulesToWrap = [];

    css.walkRules((rule) => {
        let parent = rule.parent;
        while (parent) {
            if (parent.type === 'atrule' && parent.name === 'media' &&
                (parent.params.includes('hover: hover') || parent.params.includes('hover:hover'))) {
                return;
            }
            parent = parent.parent;
        }

        const selector = rule.selector;
        const isTailwindHover =
            selector.includes('.group:hover') ||
            (selector.includes('\\:') && selector.includes(':hover'));

        if (isTailwindHover) {
            rulesToWrap.push(rule);
        }
    });

    rulesToWrap.forEach((rule) => {
        const mediaRule = postcss.atRule({ name: 'media', params: '(hover: hover)' });
        mediaRule.append(rule.clone());
        rule.replaceWith(mediaRule);
    });
};

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

mix.autoload({
    jquery: ['$', 'jQuery', 'window.jQuery'],
});

mix.js('assets/js/app.js', 'dist/js')
    .sass('assets/sass/app.scss', 'dist/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js'), hoverMediaQueryPlugin ],
    })
    .copyDirectory('node_modules/@fortawesome/fontawesome-pro/webfonts', 'dist/fonts')
    .copyDirectory('assets/fonts', 'dist/fonts')
    .copyDirectory('./../theme-child/assets/fonts', 'dist/fonts');


if (mix.inProduction()) {
    mix.version();
}
