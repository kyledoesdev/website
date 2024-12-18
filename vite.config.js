import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import prismjs from 'vite-plugin-prismjs';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/prezet.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        prismjs({
            languages: ['php', 'javascript', 'html', 'css', 'bash', 'typescript',], // Enables dynamic loading
            theme: 'tomorrow',
            css: true,
        })
    ],
});
