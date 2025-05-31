import path from 'path'
import laravel from 'laravel-vite-plugin'
import prismjs from 'vite-plugin-prismjs'
import { defineConfig } from 'vite'
import { watchAndRun } from 'vite-plugin-watch-and-run'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        watchAndRun([
            {
                name: 'prezet:index',
                watch: path.resolve('prezet/**/*.(md|jpg|png|webp)'),
                run: 'php artisan prezet:index',
                delay: 1000,
                // watchKind: ['add', 'change', 'unlink'], // (default)
            },
        ]),
        prismjs({
            languages: ['php', 'javascript', 'html', 'css', 'bash', 'typescript'],
            theme: 'tomorrow',
            css: true,
        })
    ],
})
