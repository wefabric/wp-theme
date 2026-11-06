import path from 'path';
import { fileURLToPath } from 'url';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

/*
 |--------------------------------------------------------------------------
 | Vite Asset Management
 |--------------------------------------------------------------------------
 |
 | Replaces the previous Laravel Mix / webpack setup. Builds straight into
 | the child theme's "dist" folder (mirroring the old build-then-move step)
 | so ChildAssetServiceProvider can enqueue directly from there.
 |
 */

export default defineConfig({
    build: {
        // outDir lives outside this package's root (in ../theme-child), so
        // Vite won't auto-empty it by default - do it explicitly to avoid
        // stale build output (e.g. the old Mix files) lingering forever.
        emptyOutDir: true,
    },
    plugins: [
        laravel({
            input: [
                'assets/js/app.js',
                'assets/sass/app.scss',
            ],
            publicDirectory: '../theme-child',
            buildDirectory: 'dist',
            hotFile: '../theme-child/dist/hot',
            refresh: false,
        }),
        viteStaticCopy({
            targets: [
                { src: 'node_modules/@fortawesome/fontawesome-pro/webfonts/*', dest: 'fonts' },
                { src: '../theme-child/assets/fonts/*', dest: 'fonts' },
            ],
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                includePaths: [path.resolve(__dirname, 'node_modules')],
            },
        },
    },
});
