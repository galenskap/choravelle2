import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/themes/default.css',
                'resources/css/themes/mmchoeur.css',
                'resources/js/app.js',
                'resources/images/logo.png',
                'resources/images/favicon.png',
            ],
            refresh: true,
        }),
    ],
});
