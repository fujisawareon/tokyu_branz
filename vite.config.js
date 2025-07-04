import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/common/daterangepicker.js',
                'resources/js/common/datatables.js',
                'resources/js/common/sortable.js',
                'resources/js/contents_app.js',
                'resources/js/customer_app.js',
                'resources/js/manager_app.js',
                'resources/js/manager_project.js',

                // 各ページ単位
                'resources/css/manager/dashboard.css',
                'resources/scss/customer/my_page.scss',
                'resources/scss/manager/project/customer-analysis.scss',
                'resources/scss/manager/project/limited_contents/binder.scss',
                'resources/scss/manager/project/limited_contents/movie.scss',
                'resources/js/manager/building_list.js',
                'resources/js/manager/contents/action_btn_setting.js',
                'resources/js/manager/contents/limited_contents/binder.js',
                'resources/js/manager/contents/limited_contents/image_gallery.js',
                'resources/js/manager/contents/limited_contents/movie.js',
                'resources/js/manager/contents/plan.js',
                'resources/js/manager/contents/sales_status.js',
                'resources/js/manager/dashboard.js',
                'resources/js/manager/manager_show.js',
                'resources/js/manager/project/customer/search.js',
                'resources/js/manager/project/customer/list.js',

                'resources/js/customer/sample.jsx',
                'resources/js/limited_contents/image_gallery/App.jsx',
                'resources/js/limited_contents/binder/App.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],
    optimizeDeps: {
        include: ['moment', 'jquery', 'daterangepicker'],
    },
    server: {
        host: true,
        cors: true,
        hmr: {
            host: 'localhost',
        },
    },
});
