import { defineConfig } from 'vite';
import { resolve, relative, extname } from 'path';
import { globSync } from 'glob';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import FullReload from 'vite-plugin-full-reload';
import vitePluginWatchAndConvertWebP from './vite-plugin-watch-and-convert-webp.mjs';

const root = resolve(__dirname, 'src');

const htmlFiles = Object.fromEntries(
    globSync('src/**/*.html', {
        ignore: ['**/dist/**'],
    }).map((file) => {
        const filename = relative('src', file.slice(0, file.length - extname(file).length));
        return [filename, fileURLToPath(new URL(file, import.meta.url))];
    })
);

const scssFiles = Object.fromEntries(
    globSync('src/scss/**/*.scss', {
        ignore: ['src/**/_*.scss', '**/dist/**'],
    }).map((file) => {
        const filename = path.basename(file, path.extname(file));
        return [filename, fileURLToPath(new URL(file, import.meta.url))];
    })
);

// 静的開発用のinput設定。
const inputsForStatic = {
    ...scssFiles,
    ...htmlFiles,
};

// WordPress用ビルドのinput設定。
const inputsForWordPress = {
    ...scssFiles,
};

export default defineConfig(({ mode }) => ({
    root,
    base: './',
    server: {
        port: 5173,
        origin: mode == 'wp' ? undefined : 'http://localhost:5173',
    },
    build: {
        outDir: mode === 'wp' ? resolve(__dirname, 'wordpress/themes/WORDPRESS-THEME-NAME/') : resolve(__dirname, 'dist'),
        emptyOutDir: false,
        rollupOptions: {
            input: mode === 'wp' ? inputsForWordPress : inputsForStatic,
            output: {
                entryFileNames: 'assets/js/[name].js',
                chunkFileNames: 'assets/js/[name].js',
                assetFileNames: (assetsInfo) => {
                    // CSSファイルの場合
                    if (assetsInfo.name.endsWith('.css')) {
                        return 'assets/css/[name][extname]';
                    }
                    // その他のファイル
                    return 'assets/[name][extname]';
                },
            },
        },
    },
    plugins: [
        FullReload(
            // ファイルの変更を検知
            ['wordpress/themes/**/*.php', 'src/**/*.html', 'src/scss/**/*.scss', 'src/public/assets/js/**/*.js']
        ),
        vitePluginWatchAndConvertWebP({
            isOptimize: true,
            jpgOptions: { quality: 90 },
            pngOptions: { quality: 90 },
            gifOptions: { quality: 90 }
          }),
    ].filter(Boolean),
}));
