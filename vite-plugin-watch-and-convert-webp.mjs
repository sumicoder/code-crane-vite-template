import sharp from 'sharp';
import fs from 'fs';
import path from 'path';
import { globSync } from 'glob';

export default function vitePluginWatchAndConvertWebP() {
    // WebP変換のみ行う関数（開発時の監視用）
    const convertToWebP = async (filePath) => {
        const ext = path.extname(filePath).toLowerCase();
        const baseName = path.basename(filePath, ext);
        const dirName = path.dirname(filePath);

        if (/\.(png|jpg|jpeg)$/i.test(ext)) {
            try {
                // WebP変換のみ
                const webpPath = path.join(dirName, `${baseName}.webp`);
                if (!fs.existsSync(webpPath)) {
                    await sharp(filePath).webp({ quality: 90 }).toFile(webpPath);
                }
            } catch (err) {
                console.error('WebP変換エラー:', err);
            }
        }
    };

    // 画像圧縮とWebP変換を行う関数（ビルド時用）
    const compressAndConvertImage = async (filePath) => {
        const ext = path.extname(filePath).toLowerCase();
        const baseName = path.basename(filePath, ext);
        const dirName = path.dirname(filePath);

        if (/\.(png|jpg|jpeg)$/i.test(ext)) {
            try {
                // WebP変換を行う
                const webpPath = path.join(dirName, `${baseName}.webp`);
                if (!fs.existsSync(webpPath)) {
                    await sharp(compressedPath).webp({ quality: 90 }).toFile(webpPath);
                }
            } catch (err) {
                console.error('画像処理エラー:', err);
            }
        }
    };

    // ファイル名がコピーファイルかどうかを判定する関数
    const isCopyFile = (filename) => {
        // ファイル名の部分だけを取得
        const basename = path.basename(filename);
        // " copy" または " コピー" という文字列が含まれる場合のみ除外
        return / copy|\scopy|\sコピー/.test(basename);
    };

    return {
        name: 'vite-plugin-watch-and-convert-webp',
        configureServer(server) {
            const baseDir = path.resolve(process.cwd(), 'src/public/assets/images');
            if (!fs.existsSync(baseDir)) return;

            // 監視対象ディレクトリ（baseDirとその直下のディレクトリすべて）
            const targetsDir = [baseDir];
            // baseDir直下のサブディレクトリも追加
            fs.readdirSync(baseDir, { withFileTypes: true })
                .filter((dirent) => dirent.isDirectory())
                .forEach((dirent) => {
                    targetsDir.push(path.join(baseDir, dirent.name));
                });

            // 最初に既存のすべての画像をWebP変換のみ処理（圧縮なし）
            const imageFiles = globSync(`${baseDir}/**/*.{png,jpg,jpeg}`, {
                ignore: ['**/*.webp'],
            }).filter((file) => !isCopyFile(file));
            imageFiles.forEach(convertToWebP);

            // 監視開始
            targetsDir.forEach((dir) => {
                fs.watch(dir, (eventType, filename) => {
                    // .webpファイル、または特定のコピーファイルは無視
                    if (!filename || /\.webp$/i.test(filename) || isCopyFile(filename)) return;

                    if (eventType === 'rename' && /\.(png|jpg|jpeg)$/i.test(filename)) {
                        const filePath = path.join(dir, filename);
                        // ファイルが存在する場合のみWebP変換（圧縮なし）
                        if (fs.existsSync(filePath)) {
                            convertToWebP(filePath);
                        }
                    }
                });
            });
        },
        // ビルド前に実行する処理
        buildStart() {
            const baseDir = path.resolve(process.cwd(), 'src/public/assets/images');
            if (!fs.existsSync(baseDir)) return;

            // webpファイルを除くすべての画像を処理
            const imageFiles = globSync(`${baseDir}/**/*.{png,jpg,jpeg}`, {
                ignore: ['**/*.webp'],
            }).filter((file) => !isCopyFile(file));

            // ビルド時には圧縮とWebP変換の両方を実行
            Promise.all(imageFiles.map(compressAndConvertImage))
                .then(() => console.log('すべての画像処理が完了しました'))
                .catch((err) => console.error('画像処理中にエラーが発生しました:', err));
        },
    };
}
