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
            ],
            refresh: true,
            publicDirectory: 'public',
            buildDirectory: 'build',
            copyDirectory: {
                'resources/fonts': 'public/fonts',
                'resources/images': 'public/images'
            }
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources',
            '@resources': '/resources',
        },
    },
    build: {
        rollupOptions: {
            input: {
                main: '/resources/css/app.css',
            },
        },
    },
    publicDir: 'public',
    assetsInclude: ['**/*.ttf'],
    copy: [
        {
            from: 'resources/fonts',
            to: 'public/fonts'
        }
    ]
});
