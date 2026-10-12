import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Parisienne', { weights: [400], preload: [{ weight: 400 }] }),
                bunny('Alegreya', { weights: [400, 500, 600], preload: [{ weight: 500 }] }),
                bunny('Work Sans', { weights: [400, 500, 600], preload: [{ weight: 400 }] }),
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
