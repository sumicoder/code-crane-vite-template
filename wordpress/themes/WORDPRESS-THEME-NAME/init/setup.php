<?php

/* ---------- セットアップ ---------- */
function my_setup()
{
	add_theme_support('post-thumbnails'); // アイキャッチ画像を有効化
	add_theme_support('automatic-feed-links'); // 投稿とコメントのRSSフィードのリンクを有効化
	add_theme_support('title-tag'); // タイトルタグ自動生成
	add_theme_support('widgets');
	add_theme_support('menus');
	add_theme_support(
		'html5',
		array( // HTML5でマークアップ
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
}
add_action('after_setup_theme', 'my_setup');

/* ---------- Adobe Fontsの読み込み ---------- */
function add_adobe_fonts_script()
{
?>
	<script>
	</script>
<?php
}
add_action('wp_head', 'add_adobe_fonts_script');

/* ---------- pタグとbrタグの自動挿入を解除 ---------- */
function disable_output()
{
	remove_filter('the_content', 'wpautop');  // 本文欄
	// remove_filter('the_title', 'wpautop');  // タイトル蘭
	// remove_filter('comment_text', 'wpautop');  // コメント欄
	remove_filter('the_excerpt', 'wpautop');  // 抜粋欄
}
add_action('init', 'disable_output');

/* ---------- 固定ページで抜粋を使えるようにする ---------- */
function enable_page_excerpt()
{
	add_post_type_support('page', 'excerpt');
}
add_action('init', 'enable_page_excerpt');

/* ---------- マイグレーションでnode_modulesを除外 ---------- */
$my_theme = wp_get_theme();
$_theme_name = $my_theme->stylesheet;

add_filter(
	'ai1wm_exclude_themes_from_export',
	function ($exclude_filters) {
		global $_theme_name;
		$exclude_filters = array(
			"{$_theme_name}/gulp/node_modules",
		);
		return $exclude_filters;
	}
);

/* ---------- サイドバーメニューから既存のタグを削除 ---------- */
function remove_menu() {
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}
add_action('admin_menu', 'remove_menu');

/* ---------- デフォルトのテーブルブロックにsimplebarを追加 ---------- */
function add_simplebar_table_block_render($block_content, $block)
{
	// テーブルブロックかどうかを確認
	if ($block['blockName'] === 'core/table') {
		// スクロールバーを設定
		$block_content = str_replace('<figure class="wp-block-table', '<figure data-simplebar data-simplebar-auto-hide="false" class="wp-block-table', $block_content);
	}
	return $block_content;
}
add_filter('render_block', 'add_simplebar_table_block_render', 10, 2);
