<?php
/**
 * 商品情報登録 API v1
 *
 * 2026/05/19 改修
 *  - 資料1〜3がCSVに出力されない不具合を修正
 *    （内側のサブクエリで RankedDocuments を JOIN しており、外側の RankedDocuments_1/2/3 と
 *      二重 JOIN になっていたため、内側を撤去）
 *  - 削除：仕様2〜6（item_name_2〜6 / item_about_2〜6）
 *  - 削除：動画・3Dモデル1/2 と各サムネイル
 *           （color_3d_movie_1/2, color_3d_movie_thumbnail_1/2）
 *  - 追加：資料4〜7（document_name_4〜7 / document_url_4〜7 / document_link_blank_4〜7）
 */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] )[0];
require_once( $parse_uri . 'wp-load.php' );
require_once( $parse_uri . '/wp-content/themes/maker/assets/api/v1/common/data-operation.php' );
global $wpdb;

ini_set("memory_limit", "512M");

$json = file_get_contents("php://input");
$contents = json_decode($json, true);

// 商品情報を取得
$term_query = "";
if (isset($_POST["p_parent_cat"]) && $_POST["p_parent_cat"] != 0) {
    $p_term_id = $_POST["p_parent_cat"];
    $p_terms = get_terms(
        'products-cat',
        array(
            'parent' => $p_term_id,
            'hide_empty' => false,
        ),
    );
    $term_ids = array_column($p_terms, 'term_id'); // カテゴリーIDのリストを取得
    $term_ids_str = implode(',', $term_ids); // 配列をカンマ区切りの文字列に変換
    $term_query = " AND wp_terms.term_id IN ($term_ids_str) "; // SQLクエリに挿入
}

$query = "WITH RankedColors AS (
	SELECT
		wp_cfs_values.post_id,
		wp_cfs_values.weight,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_model_number' THEN wp_postmeta.meta_value END), '') AS color_model_number,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'product_color_name' THEN wp_postmeta.meta_value END), '') AS product_color_name,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'product_color_code' THEN wp_postmeta.meta_value END), '') AS product_color_code,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'price_color_non_taxed' THEN wp_postmeta.meta_value END), '') AS price_color_non_taxed,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_file_1' THEN wp_postmeta.meta_value END), '') AS color_file_1,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_file_2' THEN wp_postmeta.meta_value END), '') AS color_file_2,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_file_3' THEN wp_postmeta.meta_value END), '') AS color_file_3,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_file_4' THEN wp_postmeta.meta_value END), '') AS color_file_4,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_file_5' THEN wp_postmeta.meta_value END), '') AS color_file_5,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_file_6' THEN wp_postmeta.meta_value END), '') AS color_file_6,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_file_7' THEN wp_postmeta.meta_value END), '') AS color_file_7,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'color_youtube_movie' THEN wp_postmeta.meta_value END), '') AS color_youtube_movie
	FROM
		wp_cfs_values
	LEFT JOIN
		wp_postmeta ON wp_postmeta.meta_id = wp_cfs_values.meta_id
	WHERE
		wp_cfs_values.base_field_id = 77 -- カスタムフィールドのループ項目：product_colors のwp_cfs_valuesテーブルでのfield_id
		AND wp_postmeta.meta_key IN (
			'color_model_number',
			'product_color_name',
			'product_color_code',
			'price_color_non_taxed',
			'color_file_1',
			'color_file_2',
			'color_file_3',
			'color_file_4',
			'color_file_5',
			'color_file_6',
			'color_file_7',
			'color_youtube_movie'
		)
	GROUP BY
		wp_cfs_values.post_id,
		wp_cfs_values.weight
),
 RankedDocuments AS (
	SELECT
		wp_cfs_values.post_id,
		wp_cfs_values.weight,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'document_name' THEN wp_postmeta.meta_value END), '') AS document_name,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'document_url' THEN wp_postmeta.meta_value END), '') AS document_url,
		COALESCE(MAX(CASE WHEN wp_postmeta.meta_key = 'document_link_blank' THEN wp_postmeta.meta_value END), '') AS document_link_blank
	FROM
		wp_cfs_values
	LEFT JOIN
		wp_postmeta ON wp_postmeta.meta_id = wp_cfs_values.meta_id
	WHERE
		wp_cfs_values.base_field_id = 69 -- カスタムフィールドのループ項目：document_list のwp_cfs_valuesテーブルでのfield_id
		AND wp_postmeta.meta_key IN (
			'document_name',
			'document_url',
			'document_link_blank'
		)
	GROUP BY
		wp_cfs_values.post_id,
		wp_cfs_values.weight
 ),
 RankedMeta AS (
    SELECT
        wp_posts.ID,
        wp_postmeta.meta_key,
        wp_postmeta.meta_value
    FROM
        wp_posts
    LEFT JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
    WHERE
        wp_posts.post_type = 'products'
        AND wp_postmeta.meta_key IN (
            'model_number',
            'product_price',
            'product_merit',
            'item_1',
            'item_2',
            'item_3',
            'item_4',
            'item_5',
            'item_6',
            'item_7',
            'item_8',
            'item_9',
            'item_10',
            'item_11',
            'item_12',
            'item_13',
            'item_14',
            'item_15',
            'item_16',
            'item_17',
            'item_18',
            'item_19',
            'item_name_1',
            'item_about_1',
            'product_display_order',
            'product_image_pc',
            'product_image_sp'
        )
)
SELECT
	t_product.*,
	CONCAT(t_product.model_number, '', RankedColors.color_model_number) AS full_model_number,
	RankedColors.product_color_name,
	RankedColors.product_color_code,
	RankedColors.price_color_non_taxed,
	RankedColors.color_file_1,
	RankedColors.color_file_2,
	RankedColors.color_file_3,
	RankedColors.color_file_4,
	RankedColors.color_file_5,
	RankedColors.color_file_6,
	RankedColors.color_file_7,
	RankedColors.color_youtube_movie,
	COALESCE(RankedDocuments_1.document_name, '') AS document_name_1,
	COALESCE(RankedDocuments_1.document_url, '') AS document_url_1,
	COALESCE(RankedDocuments_1.document_link_blank, '') AS document_link_blank_1,
	COALESCE(RankedDocuments_2.document_name, '') AS document_name_2,
	COALESCE(RankedDocuments_2.document_url, '') AS document_url_2,
	COALESCE(RankedDocuments_2.document_link_blank, '') AS document_link_blank_2,
	COALESCE(RankedDocuments_3.document_name, '') AS document_name_3,
	COALESCE(RankedDocuments_3.document_url, '') AS document_url_3,
	COALESCE(RankedDocuments_3.document_link_blank, '') AS document_link_blank_3,
	COALESCE(RankedDocuments_4.document_name, '') AS document_name_4,
	COALESCE(RankedDocuments_4.document_url, '') AS document_url_4,
	COALESCE(RankedDocuments_4.document_link_blank, '') AS document_link_blank_4,
	COALESCE(RankedDocuments_5.document_name, '') AS document_name_5,
	COALESCE(RankedDocuments_5.document_url, '') AS document_url_5,
	COALESCE(RankedDocuments_5.document_link_blank, '') AS document_link_blank_5,
	COALESCE(RankedDocuments_6.document_name, '') AS document_name_6,
	COALESCE(RankedDocuments_6.document_url, '') AS document_url_6,
	COALESCE(RankedDocuments_6.document_link_blank, '') AS document_link_blank_6,
	COALESCE(RankedDocuments_7.document_name, '') AS document_name_7,
	COALESCE(RankedDocuments_7.document_url, '') AS document_url_7,
	COALESCE(RankedDocuments_7.document_link_blank, '') AS document_link_blank_7
FROM
	(
	SELECT
		wp_posts.ID AS ID,
		wp_posts.post_title AS post_title,
		wp_posts.post_name AS post_name,
		wp_posts.post_status AS post_status,
		COALESCE(subquery.term_id, '') AS term_id,
		COALESCE(subquery.term_name, '') AS term_name,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'model_number' THEN RankedMeta.meta_value END), '') AS model_number,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_price' THEN RankedMeta.meta_value END), '') AS product_price,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_merit' THEN RankedMeta.meta_value END), '') AS product_merit,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_1' THEN RankedMeta.meta_value END), '') AS item_1,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_2' THEN RankedMeta.meta_value END), '') AS item_2,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_3' THEN RankedMeta.meta_value END), '') AS item_3,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_4' THEN RankedMeta.meta_value END), '') AS item_4,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_5' THEN RankedMeta.meta_value END), '') AS item_5,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_6' THEN RankedMeta.meta_value END), '') AS item_6,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_7' THEN RankedMeta.meta_value END), '') AS item_7,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_8' THEN RankedMeta.meta_value END), '') AS item_8,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_9' THEN RankedMeta.meta_value END), '') AS item_9,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_10' THEN RankedMeta.meta_value END), '') AS item_10,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_11' THEN RankedMeta.meta_value END), '') AS item_11,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_12' THEN RankedMeta.meta_value END), '') AS item_12,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_13' THEN RankedMeta.meta_value END), '') AS item_13,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_14' THEN RankedMeta.meta_value END), '') AS item_14,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_15' THEN RankedMeta.meta_value END), '') AS item_15,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_16' THEN RankedMeta.meta_value END), '') AS item_16,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_17' THEN RankedMeta.meta_value END), '') AS item_17,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_18' THEN RankedMeta.meta_value END), '') AS item_18,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_19' THEN RankedMeta.meta_value END), '') AS item_19,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_name_1' THEN RankedMeta.meta_value END), '') AS item_name_1,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_about_1' THEN RankedMeta.meta_value END), '') AS item_about_1,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_display_order' THEN RankedMeta.meta_value END), '100') AS product_display_order,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_image_pc' THEN RankedMeta.meta_value END), '') AS product_image_pc,
		COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_image_sp' THEN RankedMeta.meta_value END), '') AS product_image_sp
	FROM
		wp_posts
	LEFT JOIN (
		SELECT
			wp_term_relationships.object_id,
			wp_terms.term_id,
			wp_terms.name AS term_name
		FROM
			wp_terms
		LEFT JOIN
			wp_term_relationships ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
		LEFT JOIN
			wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
		WHERE
			wp_term_taxonomy.taxonomy = 'products-cat' {$term_query}
			)
			AS subquery ON wp_posts.ID = subquery.object_id
	LEFT JOIN RankedMeta ON wp_posts.ID = RankedMeta.ID
	WHERE
		wp_posts.post_type = 'products' AND wp_posts.post_status NOT IN ('auto-draft', 'trash') AND subquery.term_id IS NOT NULL
	GROUP BY
		wp_posts.ID
) AS t_product
LEFT JOIN RankedColors ON RankedColors.post_id = t_product.ID
LEFT JOIN RankedDocuments AS RankedDocuments_1 ON RankedDocuments_1.weight = 0 and RankedDocuments_1.post_id = t_product.ID
LEFT JOIN RankedDocuments AS RankedDocuments_2 ON RankedDocuments_2.weight = 1 and RankedDocuments_2.post_id = t_product.ID
LEFT JOIN RankedDocuments AS RankedDocuments_3 ON RankedDocuments_3.weight = 2 and RankedDocuments_3.post_id = t_product.ID
LEFT JOIN RankedDocuments AS RankedDocuments_4 ON RankedDocuments_4.weight = 3 and RankedDocuments_4.post_id = t_product.ID
LEFT JOIN RankedDocuments AS RankedDocuments_5 ON RankedDocuments_5.weight = 4 and RankedDocuments_5.post_id = t_product.ID
LEFT JOIN RankedDocuments AS RankedDocuments_6 ON RankedDocuments_6.weight = 5 and RankedDocuments_6.post_id = t_product.ID
LEFT JOIN RankedDocuments AS RankedDocuments_7 ON RankedDocuments_7.weight = 6 and RankedDocuments_7.post_id = t_product.ID
ORDER BY
    t_product.ID,RankedColors.weight;
";

// データ取得
// WPから商品情報取得
$productData = $wpdb->get_results($query);

$returnProductData = json_decode(
    json_encode(
        array_values(
            $productData
        )
    ),
    true
);

// CSVを返却、対象のカラム名
$csvTarget = [
    'ID',
    'post_title',
    'post_name',
    'post_status',
    'term_id',
    'term_name',
    'full_model_number',
    'product_price',
    'product_merit',
    'item_1',
    'item_2',
    'item_3',
    'item_4',
    'item_5',
    'item_6',
    'item_7',
    'item_8',
    'item_9',
    'item_10',
    'item_11',
    'item_12',
    'item_13',
    'item_14',
    'item_15',
    'item_16',
    'item_17',
    'item_18',
    'item_19',
    'item_name_1',
    'item_about_1',
    // カラー
    'product_color_name',
    'product_color_code',
    'price_color_non_taxed',
    'color_file_1',
    'color_file_2',
    'color_file_3',
    'color_file_4',
    'color_file_5',
    'color_file_6',
    'color_file_7',
    'color_youtube_movie',
    // 一覧ページ設定
    'product_display_order',
    'product_image_pc',
    'product_image_sp',
    // 資料1〜7
    'document_name_1',
    'document_url_1',
    'document_link_blank_1',
    'document_name_2',
    'document_url_2',
    'document_link_blank_2',
    'document_name_3',
    'document_url_3',
    'document_link_blank_3',
    'document_name_4',
    'document_url_4',
    'document_link_blank_4',
    'document_name_5',
    'document_url_5',
    'document_link_blank_5',
    'document_name_6',
    'document_url_6',
    'document_link_blank_6',
    'document_name_7',
    'document_url_7',
    'document_link_blank_7',
];

// 項目名
$csvHeader = [
    'ID',
    '商品名',
    '商品のパーマリンク',
    '公開・非公開',
    'カテゴリーのID',
    'カテゴリー名',
    '品番',
    '希望小売価格(税抜)',
    '特長',
    'スパウト',
    '対応穴径',
    '吐水',
    '回転範囲',
    '節湯',
    'JWWA',
    'サイズ',
    '材質',
    '設置タイプ',
    '排水口径',
    'オーバーフロー',
    '付属品',
    '引き棒',
    'ボウル深さ',
    '水栓取付穴径',
    '容量',
    '重量',
    '備考1',
    '備考2',
    '仕様１ 項目名',
    '仕様１ 概要',
    // カラー
    'カラー名',
    'カラー設定',
    'カラー別希望小売価格(税抜)',
    '画像１',
    '画像２',
    '画像３',
    '画像４',
    '画像５',
    '画像６',
    '画像７',
    'youtube 動画URL',
    // 一覧ページ設定
    '表示順',
    '画像（PC）',
    '画像（スマホ）',
    // 資料1〜7
    '資料1 資料名',
    '資料1 資料リンク',
    '資料1 リンクを新規タブで開く',
    '資料2 資料名',
    '資料2 資料リンク',
    '資料2 リンクを新規タブで開く',
    '資料3 資料名',
    '資料3 資料リンク',
    '資料3 リンクを新規タブで開く',
    '資料4 資料名',
    '資料4 資料リンク',
    '資料4 リンクを新規タブで開く',
    '資料5 資料名',
    '資料5 資料リンク',
    '資料5 リンクを新規タブで開く',
    '資料6 資料名',
    '資料6 資料リンク',
    '資料6 リンクを新規タブで開く',
    '資料7 資料名',
    '資料7 資料リンク',
    '資料7 リンクを新規タブで開く',
];

$csvData = [];
foreach ($returnProductData as $index => $productDataValue) {
    foreach ($csvTarget as $csvTargetValue) {
        $csvData[$index][] = strval($productDataValue[$csvTargetValue]);
    }
}
putCsv($csvHeader, $csvData);
