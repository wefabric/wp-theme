import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import path from 'path';
// import react from '@vitejs/plugin-react';
// import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel([
            'assets/js/app.js',
            'assets/sass/app.scss',
        ]),
        // viteStaticCopy({
        //     targets: [
        //         {
        //             src: path.resolve(__dirname, 'node_modules/@fortawesome/fontawesome-pro/webfonts') + '/.*', // 1️⃣
        //             dest:  'dist/fonts', // 2️⃣
        //         },
        //         {
        //             src: path.resolve(__dirname, 'assets/fonts') + '/.*', // 1️⃣
        //             dest:  'dist/fonts', // 2️⃣
        //         },
        //         {
        //             src: path.resolve(__dirname, './../theme-child/assets/fonts') + '/.*', // 1️⃣
        //             dest:  'dist/fonts', // 2️⃣
        //         },
        //     ],
        // }),
        // react(),
        // vue({
        //     template: {
        //         transformAssetUrls: {
        //             base: null,
        //             includeAbsolute: false,
        //         },
        //     },
        // }),
    ],
});