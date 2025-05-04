<?php
/* ---------- 固定ページを自動で作成 ※テーマ有効化した後は削除推奨 ---------- */
function create_pages_and_setting()
{
	$pages_array = array(
		array('title' => 'トップページ', 'name' => 'top', 'parent' => '', 'templateName' => 'front-page.php'),
		array('title' => '私たちについて', 'name' => 'about', 'parent' => '', 'templateName' => 'page-about.php'),
		array('title' => '会社概要', 'name' => 'company', 'parent' => '', 'templateName' => 'page-company.php'),
		array('title' => '実績紹介', 'name' => 'works', 'parent' => '', 'templateName' => 'archive-works.php'),
		array('title' => '商品紹介', 'name' => 'items', 'parent' => '', 'templateName' => 'archive-items.php'),
		array('title' => 'お問い合わせ', 'name' => 'contact', 'parent' => '', 'templateName' => 'page-contact.php'),
		array('title' => '採用情報', 'name' => 'recruit', 'parent' => '', 'templateName' => 'page-recruit.php'),
		array('title' => 'トピックス', 'name' => 'topics', 'parent' => '', 'templateName' => 'archive-topics.php'),
		array('title' => 'お問い合わせ 完了ページ', 'name' => 'thanks', 'parent' => '', 'templateName' => 'page-thanks.php'),
 );
	foreach ($pages_array as $key => $value) {
		setting_pages($value, $key);
	}
}

function setting_pages($val, $key)
{
	$index = $key + 1;
	//親ページ判別
	if (!empty($val['parent'])) {
		$parent_id = get_page_by_path($val['parent']);
		$parent_id = $parent_id->ID;
		$page_slug = $val['parent'] . "/" . $val['name'];
	} else {
		$parent_id = "";
		$page_slug = $val['name'];
	}
	if (empty(get_page_by_path($page_slug))) {
		//固定ページがなければ作成
		wp_insert_post(
			array(
				'post_title' => $val['title'],
				'post_name' => $val['name'],
				'post_status' => 'publish',
				'post_type' => 'page',
				'post_parent' => $parent_id,
				'post_content' => '',
				'post_date' => '2024-01-' . sprintf('%02d', $index) . ' 00:00:00',
				'page_template' => $val['templateName']
			)
		);
	}
}
add_action('after_setup_theme', 'create_pages_and_setting');
