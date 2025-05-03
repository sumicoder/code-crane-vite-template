<?php
/* ---------- 初期投稿／固定ページを削除 ---------- */
wp_delete_post( 1, true ); // 「Hello world」
wp_delete_post( 2, true ); // 「Sample Page」
wp_delete_post( 3, true ); // 「Privacy Policy」