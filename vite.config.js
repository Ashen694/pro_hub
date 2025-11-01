import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Your project's main assets
                'resources/css/app.css',
                'resources/js/app.js',

                // Assets for the 'My Work' section
                'resources/css/backup-matrix.css',
                'resources/css/weekly-create.css',
                'resources/css/weekly-edit.css',
                'resources/css/weekly-index.css',
                'resources/css/weekly-report.css',
                'resources/js/backup-matrix.js',
                'resources/js/weekly-create.js',
                'resources/js/weekly-edit.js',
                'resources/js/weekly-index.js',
                'resources/js/weekly-report.js',
            ],
            refresh: true,
        }),
    ],
});