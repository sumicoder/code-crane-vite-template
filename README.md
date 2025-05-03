# code-crane-vite-template

ご自身の作業ディレクトリにクローンしてください。

## 概要

1.  MacOS 環境を前提としています。（Windows のかたは、NPM Scripts に rm コマンド（`dist`ディレクトリ削除）が入っているので適宜置き換えてください）
2.  js は納品後に先方でも編集できるようにバンドルしない方式を取ってます。
3.  Sass（Scss）を使用します。
4.  WordPress 開発は wp-env × Docker を使用して開発します。
5.  静的アセット開発でも使用可能です。

## 環境

-   Node.js
-   Docker
-   Vite
-   Sass

## 事前準備

1. リポジトリをクローン（もしくは zip ダウンロード）する。
2. `/wordpress/themes/`にあるテーマファイル名「`WORDPRESS-THEME-NAME`」を開発テーマ名（任意）にする。
3. `.wp-env.json`にある`"mappings"`のオブジェクトにある文字列（下記参照）を`2`で変更したテーマ名に変更する。

```json
    "mappings": {
        "wp-content/themes/WORDPRESS-THEME-NAME/": "./wordpress/themes/WORDPRESS-THEME-NAME/",
        :
    }
```

> `/WORDPRESS-THEME-NAME/`の部分 2 箇所

4. `package.json`にある`NPM Scripts`の文字列（下記参照）を`2`で変更したテーマ名に変更する。

```json:package.json
"env:init": "wp-env start && wp-env run cli wp theme activate WORDPRESS-THEME-NAME && wp-env run cli wp theme delete --all && wp-env run cli wp option update timezone_string 'Asia/Tokyo' && wp-env run cli wp option update posts_per_page 1 && wp-env run cli wp option update permalink_structure /%postname%/ && wp-env run cli wp option update blog_public 0"
```

> `&& wp-env run cli wp theme activate WORDPRESS-THEME-NAME`の`WORDPRESS-THEME-NAME`の部分 1 箇所

5.  `vite.config.mjs`にある`outDir`の文字列（下記参照）を`2`で変更したテーマ名に変更する。

```js:vite.config.mjs
outDir: mode === 'wp' ? resolve(__dirname, 'wordpress/themes/WORDPRESS-THEME-NAME/') : resolve(__dirname, 'dist'),
```

> `&& wp-env run cli wp theme activate WORDPRESS-THEME-NAME`の`WORDPRESS-THEME-NAME`の部分 1 箇所

## 立ち上げ

### 静的サイト開発の場合

1. 開発ディレクトリで`npm i`（node_module インストール）
2. `npm run dev`（ローカルホスト起動）

:::

-   `/sql`
-   `/wordpress`
-   `.htaccess`

は不要です
:::

#### ビルドについて

1.  `npm run build`で`/dist`ディレクトリが生成されます。
2.  `/dist`以下のアセットを納品してください。

---

### WordPress 開発の場合

1. 開発ディレクトリで`npm i`（node_module インストール）
2. `npm run dev`（ローカルホスト起動）
3. 開発ディレクトリで`npm run env:init`（初回起動のみ）
    - 2 回目以降は`npm run start`
    - Docker に WordPress がインストールされます。
4. `http://localhost:8888/`にアクセスします。

#### WordPress ログイン

サイト URL：`http://localhost:8888/`

管理画面 URL：`http://localhost:8888/wp-admin/`

ユーザー名：`admin`

パスワード：`password`

#### ビルドについて

1.  `npm run build-for-wp`で`/wordpress/themes/WORDPRESS-THEME-NAME/`ディレクトリに`assets`ディレクトリが生成されます。
2.  `/WORDPRESS-THEME-NAME/`を本番環境の`wp-content/themes/`ディレクトリに格納してください。

## 開発について

静的サイト開発の場合は全て`/src`ディレクトリ以下で作業します。

-   scss - `/src/scss/`
-   js - `/src/public/assets/js/`
-   images - `/src/public/assets/images/`

WordPress の場合 PHP ファイルの変更のみ`/wordpress`ディレクトリ以下で作業します。

-   scss - `/src/scss/`
-   js - `/src/public/assets/js/`
-   images - `/src/public/assets/images/`
-   php - `/wordpress/themes/WORDPRESS-THEME-NAME/`

### 画像の取り扱いについて（重要）

-   `/src/public/assets/images`以下のディレクトリはそのまま維持されます。
-   `npm run dev`した状態で画像を格納すると同階層に webp 画像が生成されます。
    -   " copy"（半角スペースがある） または " コピー" という文字列が含まれる場合は除外されます。（`catchcopy.png`などは問題ないです。）
-   画像の src や url は必ず`/assets`から書き始めてください。
    -   Vite がいい感じにパス解決してくれます。

#### _html_

```html:index.html
<div>
    <picture>
        <source srcset="/assets/images/static.webp" width="300" height="300" type="image/webp" />
        <img src="/assets/images/static.png" alt="" width="300" height="300" />
    </picture>
</div>
```

#### _css(scss)_

```scss:style.scss
.bg {
    background-image: url(/assets/images/background.png);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    width: 300px;
    height: 300px;
}
```

#### _js_

```JavaScript:script.js
const imgsrc = "/assets/images/js.png";

console.log("console aaa");

// jsから画像を読み込むサンプル
const canvas = document.querySelector("#canvas");
const context = canvas.getContext("2d");
const image = new Image(300, 300);
image.src = imgsrc;
image.addEventListener("load", () => {
  context?.drawImage(image, 0, 0, 300, 300);
});
```

## データベースの共有

複数人での開発ではデータベースごと共有することで環境差異や投稿内容の差分を限りなくゼロにできます。

1.  開発ディレクトリで`npm run export`
    -   データベースの内容が`/sql/wpenv.sql`にエクスポートされます。
    -   このファイルを Git などで共有します。
2.  共同開発者は Git から更新内容を（`/sql/wpenv.sql`に変更があれば）プルします。
3.  開発ディレクトリで`npm run import`すると投稿やカスタムフィールドのデータなども統合されます。

**`/sql/wpenv.sql`は Git でも差分管理されないので、同時に export した場合、後から Git に push したほうで上書きされますので、共同開発者と連携を取ってください。**

## 簡単な仕組み解説

### ホットリロードについて

`npm run dev`で Vite サーバーを立ち上げた状態で Docker も立ち上げ、`WP_DEBUG`の真偽値によって読み込むアセットを変えてます。（下記参照）

```php:init/my-scripts.php
if (WP_DEBUG) {
    // Vite
    echo '<script type="module" src="http://localhost:5173/@vite/client"></script>';
    // テーマのJavaScript
    wp_enqueue_script('theme-common', 'http://localhost:5173/assets/js/common.js', array('gsap', 'swiper', 'scroll-hint', 'simplebar', 'yubinbango'), '', true);
    // テーマのCSS
    wp_enqueue_style('theme-style', 'http://localhost:5173/scss/style.scss', array(), '');
} else {
    // テーマのJavaScript
    wp_enqueue_script('theme-common', get_theme_file_uri('/assets/js/common.js'), array('gsap', 'swiper', 'scroll-hint', 'simplebar', 'yubinbango'), filemtime(get_theme_file_path('/assets/js/common.js')), true);
    // テーマのCSS
    wp_enqueue_style('theme-style', get_theme_file_uri('/assets/css/style.css'), array(), filemtime(get_theme_file_path('/assets/css/style.css')));
}
```

もうすこしいいやり方がないか模索中です。。。

### 画像パス解決ついて

ホットリロードと同じく`WP_DEBUG`の真偽値によって変数を変えてます。（下記参照）

```php:init/define.php
if (WP_DEBUG) {
    define('IMAGEPATH', 'http://localhost:5173/assets/images');
} else {
    define('IMAGEPATH', get_template_directory_uri() . '/assets/images');
}
```

**上記の条件分岐は、納品時には不要なので忘れずに削除してください。**
**WordPress エラー調査の際に WP_DEBUG を true にすることがあるので、その時にバグります。**

## よく使うコマンド

-   初回起動

```
npm run env:init
```

-   作業終了時

```
npm run stop
```

-   2 階目以降の作業開始時

```
npm run start
```

-   データベースエクスポート

```
npm run export
```

-   データベースインポート

```
npm run import
```

### Docker コンテナの名前変更

```
# docker rename OLD_CONTAINER_NAME NEW_CONTAINER_NAME
```

### 大元の WordPress ファイル

大元の WordPress ファイルは`User/NAME/.wp-env`というディレクトリにあります。

ファイル名はハッシュのようになっているので、上記のコマンドでコンテナ名だけでも変更しておくと良いです。
