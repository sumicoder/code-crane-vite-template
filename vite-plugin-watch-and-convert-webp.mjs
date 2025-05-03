import sharp from 'sharp';
import fs from 'fs';
import path from 'path';
import { globSync } from 'glob';

export default function vitePluginWatchAndConvertWebP() {
    // 共通の定数
    const BASE_DIR = path.resolve(process.cwd(), 'src/public/assets/images');
    const IMAGE_PATTERN = '**/*.{png,jpg,jpeg}';

    // ファイル名がコピーファイルかどうかを判定する関数
    const isCopyFile = (filename) => {
        const basename = path.basename(filename);
        return / copy|\scopy|\sコピー/.test(basename);
    };

    // 画像ファイルを検索する関数
    const findImageFiles = () => {
        if (!fs.existsSync(BASE_DIR)) return [];

        return globSync(`${BASE_DIR}/${IMAGE_PATTERN}`, {
            ignore: ['**/*.webp'],
        }).filter((file) => !isCopyFile(file));
    };

    // WebP変換を行う関数（基本ロジック）
    const convertToWebP = async (filePath, options = { quality: 90 }) => {
        const ext = path.extname(filePath).toLowerCase();
        const baseName = path.basename(filePath, ext);
        const dirName = path.dirname(filePath);

        if (!/\.(png|jpg|jpeg)$/i.test(ext)) return;

            try {
                // WebP変換を行う
                const webpPath = path.join(dirName, `${baseName}.webp`);
                if (!fs.existsSync(webpPath)) {
                    return await sharp(filePath).webp(options).toFile(webpPath);
                }
            } catch (err) {
                console.error('WebP変換エラー:', err);
            }
    };

    // 開発サーバー起動前にすべての画像を同期的に処理する関数
    const processAllImagesBeforeServerStart = () => {
        if (!fs.existsSync(BASE_DIR)) return Promise.resolve();

        const imageFiles = findImageFiles();

        // 同期的に処理するため、Promiseで全ての処理の完了を待つ
        const allPromises = imageFiles.map((filePath) => {
            return new Promise((resolve) => {
                sharp(filePath)
                    .webp({ quality: 90 })
                    .toFile(path.join(path.dirname(filePath), `${path.basename(filePath, path.extname(filePath))}.webp`), () => resolve());
            });
        });

        // すべての変換が終わるまで待機
        return Promise.all(allPromises).then(() => console.log('すべての画像のWebP変換が完了しました'));
    };

    // 監視対象のディレクトリをすべて取得
    const getTargetDirectories = () => {
        if (!fs.existsSync(BASE_DIR)) return [];

        const targetsDir = [BASE_DIR];

        // BASE_DIR直下のサブディレクトリも追加
        fs.readdirSync(BASE_DIR, { withFileTypes: true })
            .filter((dirent) => dirent.isDirectory())
            .forEach((dirent) => {
                targetsDir.push(path.join(BASE_DIR, dirent.name));
            });

        return targetsDir;
    };

    return {
        name: 'vite-plugin-watch-and-convert-webp',
        // 最も早いタイミングでWebP変換を実行
        configResolved(config) {
            // 開発モードの場合のみ事前変換を実行
            if (config.command === 'serve') {
                return processAllImagesBeforeServerStart();
            }
        },
        configureServer(server) {
            if (!fs.existsSync(BASE_DIR)) return;

            // 監視開始
            getTargetDirectories().forEach((dir) => {
                fs.watch(dir, (eventType, filename) => {
                    // .webpファイル、または特定のコピーファイルは無視
                    if (!filename || /\.webp$/i.test(filename) || isCopyFile(filename)) return;

                    if (eventType === 'rename' && /\.(png|jpg|jpeg)$/i.test(filename)) {
                        const filePath = path.join(dir, filename);
                        // ファイルが存在する場合のみWebP変換
                        if (fs.existsSync(filePath)) {
                            convertToWebP(filePath);
                        }
                    }
                });
            });
        },
        // ビルド前に実行する処理
        buildStart() {
            if (!fs.existsSync(BASE_DIR)) return;

            // ビルド時にはすべての画像を処理
            const imageFiles = findImageFiles();

            // ビルド時には圧縮とWebP変換の両方を実行
            Promise.all(imageFiles.map((filePath) => convertToWebP(filePath, { quality: 90 })))
                .then(() => console.log('すべての画像処理が完了しました'))
                .catch((err) => console.error('画像処理中にエラーが発生しました:', err));
        },
    };
}
