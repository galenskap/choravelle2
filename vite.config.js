import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        // Ensure the assets directory exists in public
        outDir: 'public',
    },
    publicDir: 'resources',  // Set resources as the public directory
    resolve: {
        alias: {
            '@': '/resources',  // Allow using @/ to reference resources directory
        },
    },
});
