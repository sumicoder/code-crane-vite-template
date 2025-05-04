<?php

/* ---------- WordPressバージョン情報の削除 ---------- */
remove_action('wp_head', 'wp_generator');

/* ---------- 投稿者一覧ページの削除 ---------- */
add_filter('author_rewrite_rules', '__return_empty_array');
function disable_author_archive()
{
	if (preg_match('#/author/.+#', $_SERVER['REQUEST_URI'])) {
		wp_redirect(esc_url(home_url('/404.php')));
		exit;
	}
}
add_action('init', 'disable_author_archive');
