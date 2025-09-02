import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        target: 'es2015',
        minify: 'terser', // Utiliser terser au lieu d'esbuild pour réduire la charge
        rollupOptions: {
            maxParallelFileOps: 1, // Réduire le parallélisme pour économiser les ressources
            output: {
                manualChunks: {
                    vendor: ['vue', '@inertiajs/vue3'],
                },
            },
        },
        chunkSizeWarningLimit: 1000,
        sourcemap: false,
    },
    optimizeDeps: {
        include: ['@vueuse/core'],
        force: true,
    },
    server: {
        hmr: false,
    },
    esbuild: {
        target: 'es2015',
        // Limiter le parallélisme d'esbuild
        logLevel: 'error',
    },
    // Limiter le parallélisme global
    worker: {
        format: 'es',
    },
});
