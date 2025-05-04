<?php get_header(); ?>
	<h1>ここは トピックス の詳細ページ<br />タイトルは <?php the_title(); ?> です</h1>
	<h2>以下は 投稿詳細ページの中身です</h2>
	<div class="wp-block-contents-wrapper"><?php the_content(); ?></div>
<?php get_footer();