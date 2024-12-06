import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/vendors/mdi/css/materialdesignicons.min.css', 'resources/vendors/base/vendor.bundle.base.css', 'resources/js/off-canvas.js', 'resources/js/template.js', 'resources/js/jquery.cookie.js' ],
            refresh: true,
        }),
        vue()
    ],
    
});
