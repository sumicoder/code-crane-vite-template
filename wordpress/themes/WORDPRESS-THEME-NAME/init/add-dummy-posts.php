<?php
/* ---------- ダミー投稿を自動で作成 ※テーマ有効化した後は削除推奨 ---------- */
function create_posts_and_setting()
{
	$dummyDataHtmlTagsTitle = '主要なHTMLタグ';

	$dummyDataHtmlTagsContent = '<!-- wp:heading -->
<h2 class="wp-block-heading">↓見出し系</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">見出し壱</h1>
<!-- /wp:heading -->

<!-- wp:heading -->
<h2 class="wp-block-heading">見出し弐</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">見出し参</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">見出し四</h4>
<!-- /wp:heading -->

<!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">見出し五</h5>
<!-- /wp:heading -->

<!-- wp:heading {"level":6} -->
<h6 class="wp-block-heading">見出し六</h6>
<!-- /wp:heading -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓HTML 要素タグテスト</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>これは <a href="http://example.com/" rel="nofollow">aタグ</a> (もしくはリンクとも呼ばれます) の例です。</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>これはpタグの例です。これはpタグの例です。これはpタグの例です。これはpタグの例です。<br>改行はこのようになります。改行はこのようになります。改行はこのようになります。改行はこのようになります。改行はこのようになります。改行はこのようになります。<br>改行はこのようになります。改行はこのようになります。改行はこのようになります。</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>段落が変わる場合はこのようになります。段落が変わる場合はこのようになります。段落が変わる場合はこのようになります。段落が変わる場合はこのようになります。段落が変わる場合はこのようになります。</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">これはボタンです</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:details -->
<details class="wp-block-details"><summary>アコーディオンの見出し＜summary＞</summary><!-- wp:paragraph {"placeholder":"「/」を入力して非表示ブロックを追加する"} -->
<p>アコーディオンの中身アコーディオンの中身アコーディオンの中身アコーディオンの中身</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>一行の引用。一行の引用。一行の引用。</p>
<!-- /wp:paragraph --></blockquote>
<!-- /wp:quote -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。複数行の引用。</p>
<!-- /wp:paragraph --></blockquote>
<!-- /wp:quote -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓区切り線</h2>
<!-- /wp:heading -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓テーブル</h2>
<!-- /wp:heading -->

<!-- wp:table {"hasFixedLayout":false} -->
<figure class="wp-block-table"><table><thead><tr><th>社員</th><th>給料</th><th></th></tr></thead><tbody><tr><th><a href="http://example.org/">山田太郎</a></th><td>1ドル</td><td>スティーブ・ジョブズが必要なサラリーと同じ額。</td></tr><tr><th><a href="http://example.org/">田中花子</a></th><td>1,000万円</td><td>ブログを書くために必要になる資金。</td></tr><tr><th><a href="http://example.org/">山本次郎</a></th><td>1億円</td><td>百聞は一見にしかず、ということで、カメラマンはブロガーの100倍。</td></tr><tr><th><a href="http://example.org/">中山愛子</a></th><td>10億円</td><td>特に理由は要りません。</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓テーブル ストライプ</h2>
<!-- /wp:heading -->

<!-- wp:table {"className":"is-style-stripes"} -->
<figure class="wp-block-table is-style-stripes"><table class="has-fixed-layout"><thead><tr><th>社員</th><th>給料</th><th></th></tr></thead><tbody><tr><th><a href="http://example.org/">山田太郎</a></th><td>1ドル</td><td>スティーブ・ジョブズが必要なサラリーと同じ額。</td></tr><tr><th><a href="http://example.org/">田中花子</a></th><td>1,000万円</td><td>ブログを書くために必要になる資金。</td></tr><tr><th><a href="http://example.org/">山本次郎</a></th><td>1億円</td><td>百聞は一見にしかず、ということで、カメラマンはブロガーの100倍。</td></tr><tr><th><a href="http://example.org/">中山愛子</a></th><td>10億円</td><td>特に理由は要りません。</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓非順序リスト (ネスト化)</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>リスト項目 1<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>リスト項目 1<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>リスト項目 1</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 2</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 3</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 4</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 2</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 3</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 4</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 2</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 3</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 4</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓順序リスト (ネスト化)</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>リスト項目 1<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>リスト項目 1<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>リスト項目 1</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 2</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 3</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 4</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list --></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 2</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 3</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 4</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list --></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 2</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 3</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>リスト項目 4</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓メディアとテキスト</h2>
<!-- /wp:heading -->

<!-- wp:media-text {"mediaId":0,"mediaType":"image"} -->
<div class="wp-block-media-text is-stacked-on-mobile"><figure class="wp-block-media-text__media"><img src="https://picsum.photos/1440/800" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:paragraph {"placeholder":"コンテンツ…"} -->
<p>この文章はだみーですこの文章はだみーですこの文章はだみーですこの文章はだみーですこの文章はだみーですこの文章はだみーですこの文章はだみーですこの文章はだみーですこの文章はだみーです。</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:media-text -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓2カラム</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"id":18} -->
<figure class="wp-block-image"><img src="https://picsum.photos/1440/800" alt="" class="wp-image-18"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"id":17} -->
<figure class="wp-block-image"><img src="https://picsum.photos/1440/800" alt="" class="wp-image-17"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph -->
<p>テキストが入ります本文の冒頭が入りますテキストが入ります本文の冒頭が入りますテキストが入ります本文の冒頭が入りますテキストが入りますテキストが入ります本文の冒頭が入りますテキストが入ります本文の冒頭が入りますテキストが入ります本文の冒頭が入りますテキストが入りますテキストが入ります本文の冒頭が入ります</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓グループブロック</h2>
<!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p>ここはグループブロックです。ここはグループブロックです。ここはグループブロックです。ここはグループブロックです。ここはグループブロックです。</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading -->
<h2 class="wp-block-heading">↓embed</h2>
<!-- /wp:heading -->

<!-- wp:embed {"url":"https://www.youtube.com/watch?v=rJT1c5DLEFo","type":"video","providerNameSlug":"youtube","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
https://www.youtube.com/watch?v=rJT1c5DLEFo
</div><figcaption class="wp-element-caption">キャプション（YouTube動画タイトルなど）</figcaption></figure>
<!-- /wp:embed -->
';

	$dummyDataJapaneseTitle = 'この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。';

	$dummyDataJapaneseContent = '<!-- wp:paragraph --><p>とても長い日本語のタイトルです。<br />複数行になった時の複数行を確認します。<br />また改行が正しくされるかを確認します。</p><!-- /wp:paragraph -->';

	$dummyDataEnglishTitle = 'LoremipsumdolorsitametconsecteturadipisicingelitIpsumharumquisquamdoloribusFugalaborumofficiafugiatiustosimiliquerepudiandaeharumaddebitisaeiusatqueinesteumutassumenda';

	$dummyDataEnglishContent = '<!-- wp:paragraph --><p>とても長い英語のタイトルです。<br />改行が正しくされるかを確認します。</p><!-- /wp:paragraph -->';

	$pages_array = array(
		array('title' => $dummyDataHtmlTagsTitle, 'post_type' => 'works','name' => 'works-html-tags', 'content' => $dummyDataHtmlTagsContent),
		array('title' => $dummyDataJapaneseTitle, 'post_type' => 'works','name' => 'works-japanese-title', 'content' => $dummyDataJapaneseContent),
		array('title' => $dummyDataEnglishTitle, 'post_type' => 'works','name' => 'works-english-title', 'content' => $dummyDataEnglishContent),
		array('title' => $dummyDataHtmlTagsTitle, 'post_type' => 'items','name' => 'items-html-tags', 'content' => $dummyDataHtmlTagsContent),
		array('title' => $dummyDataJapaneseTitle, 'post_type' => 'items','name' => 'items-japanese-title', 'content' => $dummyDataJapaneseContent),
		array('title' => $dummyDataEnglishTitle, 'post_type' => 'items','name' => 'items-english-title', 'content' => $dummyDataEnglishContent),
		array('title' => $dummyDataHtmlTagsTitle, 'post_type' => 'topics','name' => 'topics-html-tags', 'content' => $dummyDataHtmlTagsContent),
		array('title' => $dummyDataJapaneseTitle, 'post_type' => 'topics','name' => 'topics-japanese-title', 'content' => $dummyDataJapaneseContent),
		array('title' => $dummyDataEnglishTitle, 'post_type' => 'topics','name' => 'topics-english-title', 'content' => $dummyDataEnglishContent),
		array('title' => $dummyDataHtmlTagsTitle, 'post_type' => 'post','name' => 'post-html-tags', 'content' => $dummyDataHtmlTagsContent),
		array('title' => $dummyDataJapaneseTitle, 'post_type' => 'post','name' => 'post-japanese-title', 'content' => $dummyDataJapaneseContent),
		array('title' => $dummyDataEnglishTitle, 'post_type' => 'post','name' => 'post-english-title', 'content' => $dummyDataEnglishContent),

	);
	foreach ($pages_array as $key => $value) {
		setting_posts($value, $key);
	}
}

function setting_posts($val, $key)
{
	$index = $key + 1;
	$page_slug = $val['name'];
	if (empty(get_page_by_path($page_slug, OBJECT, $val['post_type']))) {
		//投稿がなければ作成
		wp_insert_post(
			array(
				'post_title' => $val['title'],
				'post_name' => $val['name'],
				'post_status' => 'publish',
				'post_type' => $val['post_type'],
				'post_parent' => '',
				'post_content' => $val['content'],
				'post_date' => '2024-01-' . sprintf('%02d', $index) . ' 00:00:00',
			)
		);
	}
}
add_action('after_setup_theme', 'create_posts_and_setting');
