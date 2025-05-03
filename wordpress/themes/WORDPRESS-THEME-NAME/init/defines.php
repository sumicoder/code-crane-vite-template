<?php
/* ---------- パスの短縮 ---------- */
if (WP_DEBUG) {
    define('IMAGEPATH', 'http://localhost:5173/assets/images');
} else {
    define('IMAGEPATH', get_template_directory_uri() . '/assets/images');
}
// define('MOVIEPATH', get_template_directory_uri() . '/assets/movies');

/* ---------- 各ページのリンク ---------- */
define('HOME_URL', esc_url(home_url('/'))); // トップページ
define('ABOUT_URL', esc_url(home_url('/about/'))); // 私たちについて
define('COMPANY_URL', esc_url(home_url('/company/'))); // 会社概要
define('WORKS_URL', esc_url(home_url('/works/'))); // 実績紹介
define('ITEMS_URL', esc_url(home_url('/items/'))); // 商品紹介
define('CONTACT_URL', esc_url(home_url('/contact/'))); // お問い合わせ
define('RECRUIT_URL', esc_url(home_url('/recruit/'))); // 採用情報
define('TOPICS_URL', esc_url(home_url('/topics/'))); // トピックス
define('THANKS_URL', esc_url(home_url('/thanks/'))); // お問い合わせ 完了ページ

/* ---------- 外部リンク ---------- */
define('SNS_X_URL', 'https://x.com'); // X
define('SNS_INSTAGRAM_URL', 'https://instagram.com'); // インスタグラム
define('YOUTUBE_URL', 'https://youtube.com'); // YouTube
define('SHOPIFY_URL', 'https://shopify.com'); // Shopify
