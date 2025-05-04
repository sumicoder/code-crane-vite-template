<?php
/*
* Template Name: お問い合わせ 完了ページ
*/
if (empty($_GET['from']) || !isset($_GET['from'])) {
	// header('location:' . home_url('/contact')); // リダイレクト先のURL
} else {
	switch ($_GET['from']) { // お問い合わせ完了ページの内容を動的に切り替える場合のswitch文
		default:
			break;
	}
};
?>

<?php get_header(); ?>
<h1>ここは お問い合わせ 完了ページ です</h1>
<?php get_footer();