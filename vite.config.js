import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/styles.css',
                'resources/css/swiper-bundle.min.css',
                'resources/js/main.js',
                'resources/js/swiper-bundle.min.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
