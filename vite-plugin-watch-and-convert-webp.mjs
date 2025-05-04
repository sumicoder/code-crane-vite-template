import sharp from "sharp";
import fs from "fs";
import path from "path";
import { globSync } from "glob";

export default function vitePluginWatchAndConvertWebP(
  mode = "default",
  command = "serve"
) {
  // オプション
  const config = {
    isOptimize: true, // 画像最適化を行うかどうか
    jpgOptions: { quality: 80 },
    pngOptions: { quality: 80 },
    gifOptions: { quality: 80 },
    webpOptions: { quality: 80 },
  };

  // 共通の定数
  const SRC_DIR = path.resolve(process.cwd(), "public/assets/images");
  const IMAGE_PATTERN = "**/*.{png,jpg,jpeg,gif}";

  // ビルドモードに応じた出力先ディレクトリを取得
  const getOutputDir = () => {
    if (mode === "wp") {
      return path.resolve(
        process.cwd(),
        "wordpress/themes/wp-env-theme/assets/images"
      );
    }
    return path.resolve(process.cwd(), "dist/assets/images");
  };

  // ファイル名がコピーファイルかどうかを判定する関数
  const isCopyFile = (filename) => {
    const basename = path.basename(filename);
    return / copy|\scopy|\sコピー/.test(basename);
  };

  // 画像ファイルを検索する関数
  const findImageFiles = (dir, pattern = IMAGE_PATTERN) => {
    if (!fs.existsSync(dir)) return [];

    return globSync(`${dir}/${pattern}`, {
      ignore: ["**/*.webp"],
    }).filter((file) => !isCopyFile(file));
  };

  // WebP変換を行う関数（基本ロジック）
  const convertToWebP = async (
    filePath,
    options = config.webpOptions,
    outputDir = null
  ) => {
    const ext = path.extname(filePath).toLowerCase();
    const baseName = path.basename(filePath, ext);
    const dirName = outputDir || path.dirname(filePath);

    if (!/\.(png|jpg|jpeg|gif)$/i.test(ext)) return;

    try {
      // WebP変換を行う
      const webpPath = path.join(dirName, `${baseName}.webp`);

      // 出力先ディレクトリが存在しない場合は作成
      if (outputDir && !fs.existsSync(outputDir)) {
        fs.mkdirSync(outputDir, { recursive: true });
      }

      if (!fs.existsSync(webpPath)) {
        return await sharp(filePath).webp(options).toFile(webpPath);
      }
    } catch (err) {
      console.error("\u001b[1;31m WebP変換エラー:", err);
    }
  };

  // 画像を圧縮する関数
  const compressAndConvertForBuild = async (filePath, outputDir) => {
    const ext = path.extname(filePath).toLowerCase();
    const baseName = path.basename(filePath, ext);
    // 出力ディレクトリからの相対パスを取得
    const relativePath = path.relative(outputDir, filePath);
    const relativeDir = path.dirname(relativePath);
    const fileName = `${baseName}${ext}`;

    if (!/\.(png|jpg|jpeg|gif)$/i.test(ext)) return;

    try {
      // 出力先ディレクトリが存在しない場合は作成
      if (!fs.existsSync(outputDir)) {
        fs.mkdirSync(outputDir, { recursive: true });
      }

      // サブディレクトリが必要な場合は作成
      const subDir = path.join(outputDir, relativeDir);
      if (relativeDir !== "." && !fs.existsSync(subDir)) {
        fs.mkdirSync(subDir, { recursive: true });
      }

      // 元画像のサイズを取得
      const stats = fs.statSync(filePath);
      const beforeImageSize = stats.size;

      // JPG、PNG、GIFファイルを圧縮
      if (config.isOptimize) {
        let sh = sharp(filePath);

        if (/^\.jpe?g$/i.test(ext)) {
          sh = sh.jpeg(config.jpgOptions);
        } else if (/^\.png$/i.test(ext)) {
          sh = sh.png(config.pngOptions);
        } else if (/^\.gif$/i.test(ext)) {
          sh = sh.gif(config.gifOptions);
        } else {
          console.log(
            `\u001b[1;31m 対応していないファイルです。-> ${fileName}`
          );
          return;
        }

        // 一時ファイルに圧縮画像を保存（サブディレクトリ構造を維持）
        const tempFileName = `${baseName}_temp${ext}`;
        const tempPath = path.join(subDir, tempFileName);

        return new Promise((resolve) => {
          sh.toFile(tempPath, (err, info) => {
            if (err) {
              console.error("\u001b[1;31m 圧縮エラー:", err);
              resolve(null);
              return;
            }

            // 元のファイルを削除して一時ファイルをリネーム
            const finalPath = path.join(subDir, fileName);
            try {
              if (fs.existsSync(finalPath)) {
                fs.unlinkSync(finalPath);
              }
              fs.renameSync(tempPath, finalPath);

              resolve({ original: finalPath });

              // WebP変換も行う
              convertToWebP(finalPath, config.webpOptions);

              // 圧縮結果を表示
              console.log(
                `\u001b[1;32m ${path.join(relativeDir, fileName)}を${Math.round(
                  ((beforeImageSize - info.size) / beforeImageSize) * 100
                )}%圧縮しました。 ${(beforeImageSize / 1000).toFixed(
                  2
                )}KB -> ${(info.size / 1000).toFixed(2)}KB`
              );
            } catch (renameErr) {
              console.error("\u001b[1;31m ファイル置換エラー:", renameErr);
              resolve(null);
            }
          });
        });
      }
    } catch (err) {
      console.error("\u001b[1;31m 画像圧縮エラー:", err);
    }
  };

  // 開発サーバー起動前にすべての画像を同期的に処理する関数
  const processAllImagesBeforeServerStart = () => {
    if (!fs.existsSync(SRC_DIR)) return Promise.resolve();

    const imageFiles = findImageFiles(SRC_DIR);

    // 同期的に処理するため、Promiseで全ての処理の完了を待つ
    const allPromises = imageFiles.map((filePath) => {
      return new Promise((resolve) => {
        sharp(filePath)
          .webp(config.webpOptions)
          .toFile(
            path.join(
              path.dirname(filePath),
              `${path.basename(filePath, path.extname(filePath))}.webp`
            ),
            () => resolve()
          );
      });
    });

    // すべての変換が終わるまで待機
    return Promise.all(allPromises).then(() =>
      console.log("\u001b[1;34m すべての画像のWebP変換が完了しました")
    );
  };

  // 監視対象のディレクトリをすべて取得
  const getTargetDirectories = () => {
    if (!fs.existsSync(SRC_DIR)) return [];

    const targetsDir = [SRC_DIR];

    // SRC_DIR直下のサブディレクトリも追加
    fs.readdirSync(SRC_DIR, { withFileTypes: true })
      .filter((dirent) => dirent.isDirectory())
      .forEach((dirent) => {
        targetsDir.push(path.join(SRC_DIR, dirent.name));
      });

    return targetsDir;
  };

  return {
    name: "vite-plugin-watch-and-convert-webp",
    // 最も早いタイミングでWebP変換を実行
    configResolved() {
      // 開発モードの場合のみ事前変換を実行
      if (command === "serve") {
        return processAllImagesBeforeServerStart();
      }
      if (command === "build") {
        console.time("\u001b[1;35m ビルドにかかった時間");
      }
    },
    configureServer() {
      if (!fs.existsSync(SRC_DIR)) return;

      // 監視開始
      getTargetDirectories().forEach((dir) => {
        fs.watch(dir, (eventType, filename) => {
          // .webpファイル、または特定のコピーファイルは無視
          if (!filename || /\.webp$/i.test(filename) || isCopyFile(filename))
            return;

          if (
            eventType === "rename" &&
            /\.(png|jpg|jpeg|gif)$/i.test(filename)
          ) {
            const filePath = path.join(dir, filename);
            // ファイルが存在する場合のみWebP変換
            if (fs.existsSync(filePath)) {
              convertToWebP(filePath, config.webpOptions);
            }
          }
        });
      });
    },
    // ビルド後に実行する処理
    closeBundle() {
      // ビルドモードの場合のみ実行
      if (!command || command !== "build") return;

      if (!fs.existsSync(SRC_DIR)) return;

      // ビルドモードに応じた出力先ディレクトリを取得
      const outputDir = getOutputDir(mode);

      // 出力先ディレクトリを作成（存在しない場合）
      if (!fs.existsSync(outputDir)) {
        fs.mkdirSync(outputDir, { recursive: true });
      }

      console.log(`ビルドモード: ${mode || "default"}, 出力先: ${outputDir}`);

      // ビルド時にはすべての画像を処理
      const imageFiles = findImageFiles(outputDir); // 出力ディレクトリ内のすべての画像ファイルを検索
      if (imageFiles.length === 0) {
        console.log("\u001b[1;33m 処理する画像ファイルが見つかりませんでした");
        return;
      }

      // ビルド時には圧縮と変換を両方実行
      Promise.all(
        imageFiles.map((filePath) =>
          compressAndConvertForBuild(filePath, outputDir)
        )
      )
        .then((results) => {
          const successCount = results.filter(Boolean).length;
          console.log(
            `\u001b[1;34m すべての画像処理が完了しました (${successCount}/${imageFiles.length})`
          );
          console.timeEnd("\u001b[1;35m ビルドにかかった時間");
        })
        .catch((err) =>
          console.error("\u001b[1;31m 画像処理中にエラーが発生しました:", err)
        );
    },
  };
}
