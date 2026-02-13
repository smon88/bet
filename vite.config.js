import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/header.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: true,
        port: 5177,
        strictPort: true,
        hmr: { host: process.env.VITE_HMR_HOST || 'localhost' },
        watch: {
            usePolling: true,
            interval: 1000,
            ignored: ['**/storage/framework/views/**', '**/node_modules/**'],
        },
    },
});
