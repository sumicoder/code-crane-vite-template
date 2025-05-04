<?php
/* ---------- 使用するGutenbergブロック ---------- */
function allowed_block_types_all( $allowed_block_types ) {
	$allowed_block_types = array(
		'core/paragraph', // 段落
		'core/heading', // 見出し
		'core/list', // リスト
		'core/quote', // 引用
		// 'core/code', // コード
		'core/details', // 詳細
		// 'core/preformatted', // 整形済みテキスト
		'core/pullquote', // プルクオート
		'core/table', // テーブル
		'core/verse', // 詩
		// 'core/freeform', // クラシック
		'core/image', // 画像
		// 'core/gallery', // ギャラリー
		// 'core/audio', // 音声
		// 'core/cover', // カバー
		// 'core/file', // ファイル
		'core/media-text', // メディアとテキスト
		// 'core/video', // 動画
		'core/buttons', // ボタン
		'core/columns', // カラム
		'core/group', // グループ(横並び、縦並び、グリッド)
		// 'core/more', // 続き
		// 'core/nextpage', // ページ区切り
		'core/separator', // 区切り
		'core/spacer', // スペーサー
		// 'core/archives', // アーカイブ
		// 'core/calendar', // カレンダー
		// 'core/categories', // ターム/カテゴリー一覧
		// 'core/html', // カスタムHTML
		// 'core/latest-comments', // 最新のコメント
		// 'core/latest-posts', // 最新の投稿
		// 'core/page-list', // 固定ページリスト
		// 'core/rss', // RSS
		// 'core/search', // 検索
		'core/shortcode', // ショートコード
		// 'core/social-links', // ソーシャルアイコン
		// 'core/tag-cloud', // タグクラウド
		// 'core/navigation', // ナビゲーション
		// 'core/site-logo', // サイトロゴ
		// 'core/site-title', // サイトのタイトル
		// 'core/site-tagline', // サイトのキャッチフレーズ
		// 'core/query', // クエリーループ
		// 'core/avatar', // アバター
		// 'core/post-title', // 投稿タイトル
		// 'core/post-excerpt', // 抜粋
		// 'core/post-featured-image', // 投稿のアイキャッチ画像
		// 'core/post-author', // 投稿者
		// 'core/post-author-name', // 作成者名
		// 'core/post-date', // 日付/変更日
		// 'core/post-terms', // カテゴリー/タグ
		// 'core/post-navigation-link', // 次/前の投稿
		// 'core/comments', // コメント
		// 'core/post-comments-form', // 投稿コメントフォーム
		// 'core/loginout', // ログイン/ログアウト
		// 'core/term-description', // タームの説明
		// 'core/query-title', // アーカイブ/検索結果のタイトル
		// 'core/post-author-biography', // 投稿者のプロフィール情報
		'core/embed', // 埋め込み
	);
	return $allowed_block_types;
}
add_filter( 'allowed_block_types', 'allowed_block_types_all' );
