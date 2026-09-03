<?php
/**
 * 商品情報登録 API v1
 *
 */
// require("../common/config.php");
// require_once($CMS_PATH . '/wp-load.php'); // functionを読んでることになる
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] )[0];
require_once( $parse_uri . 'wp-load.php' );
require_once( $parse_uri . '/wp-content/themes/maker/assets/api/v1/common/data-operation.php' );
global $wpdb;

ini_set("memory_limit", "512M");

$json = file_get_contents("php://input");
$contents = json_decode($json, true);

// 商品情報を取得
$query = "WITH RankedColors AS (
    SELECT 
        wp_posts.ID,
        ROW_NUMBER() OVER(PARTITION BY wp_posts.ID ORDER BY wp_posts.ID) AS rn
    FROM 
        wp_posts
    LEFT JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
    WHERE wp_postmeta.meta_key = 'product_color_name'
),
RankedMeta AS (
    SELECT
        wp_posts.ID,
        wp_postmeta.meta_key,
        wp_postmeta.meta_value,
        ROW_NUMBER() OVER(PARTITION BY wp_posts.ID, wp_postmeta.meta_key ORDER BY wp_postmeta.meta_value) AS rn
    FROM 
        wp_posts
    LEFT JOIN 
        wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
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
            'item_name_2',
            'item_about_2',
            'item_name_3',
            'item_about_3',
            'item_name_4',
            'item_about_4',
            'item_name_5',
            'item_about_5',
            'item_name_6',
            'item_about_6',
            'product_color_name',
            'product_color_code',
            'color_model_number',
            'price_color_non_taxed',
            'color_file_1',
            'color_file_2',
            'color_file_3',
            'color_file_4',
            'color_file_5',
            'color_file_6',
            'color_file_7',
            'color_3d_movie_1',
            'color_3d_movie_thumbnail_1',
            'color_3d_movie_2',
            'color_3d_movie_thumbnail_2',
            'color_youtube_movie',
            'product_display_order',
            'product_image_pc',
            'product_image_sp',
            'document_name',
            'document_url',
            'document_link_blank'
        )
)
SELECT
    wp_posts.ID AS ID,
    wp_posts.post_title AS post_title,
    wp_posts.post_name AS post_name,
    wp_posts.post_status AS post_status,
    COALESCE(subquery.term_id, 0) AS term_id,
    COALESCE(subquery.term_name, '未分類') AS term_name,
    CONCAT(
        COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'model_number' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), ''),
        '-',
        COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_model_number' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '')
    ) AS full_model_number,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_price' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS product_price,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_merit' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS product_merit,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_1' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_2' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_3' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_3,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_4' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_4,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_5' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_5,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_6' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_6,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_7' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_7,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_8' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_8,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_9' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_9,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_10' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_10,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_11' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_11,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_12' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_12,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_13' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_13,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_14' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_14,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_15' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_15,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_16' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_16,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_17' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_17,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_18' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_18,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_19' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_19,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_name_1' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_name_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_about_1' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_about_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_name_2' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_name_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_about_2' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_about_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_name_3' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_name_3,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_about_3' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_about_3,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_name_4' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_name_4,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_about_4' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_about_4,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_name_5' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_name_5,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_about_5' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_about_5,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_name_6' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_name_6,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'item_about_6' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS item_about_6,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_color_name' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '不明') AS product_color_name,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_color_code' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS product_color_code,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS price_color_non_taxed,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_file_1' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_file_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_file_2' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_file_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_file_3' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_file_3,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_file_4' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_file_4,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_file_5' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_file_5,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_file_6' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_file_6,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_file_7' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_file_7,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie_1' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_3d_movie_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie_thumbnail_1' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_3d_movie_thumbnail_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie_2' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_3d_movie_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie_thumbnail_2' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_3d_movie_thumbnail_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'color_youtube_movie' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS color_youtube_movie,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_display_order' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS product_display_order,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_image_pc' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS product_image_pc,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'product_image_sp' AND RankedMeta.rn = RankedColors.rn THEN RankedMeta.meta_value END), '') AS product_image_sp,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_name' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END), '') AS document_name_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_url' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END), '') AS document_url_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_link_blank' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END), '') AS document_link_blank_1,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_name' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END), '') AS document_name_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_url' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END), '') AS document_url_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_link_blank' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END), '') AS document_link_blank_2,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_name' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END), '') AS document_name_3,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_url' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END), '') AS document_url_3,
    COALESCE(MAX(CASE WHEN RankedMeta.meta_key = 'document_link_blank' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END), '') AS document_link_blank_3
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
            wp_term_taxonomy.taxonomy = 'products-cat'
    ) AS subquery ON wp_posts.ID = subquery.object_id
    LEFT JOIN RankedMeta ON wp_posts.ID = RankedMeta.ID
    LEFT JOIN RankedColors ON wp_posts.ID = RankedColors.ID
WHERE 
    wp_posts.post_type = 'products' AND wp_posts.post_status NOT IN ('auto-draft', 'trash')
GROUP BY
    wp_posts.ID
ORDER BY
    wp_posts.ID;
";

            // ";
            // // if (isset($_POST["p_parent_cat"]) && $_POST["p_parent_cat"] != 0) {
            // //     $p_term_id = $_POST["p_parent_cat"];
            // //     $p_terms = get_terms(
            // //         'products-cat',
            // //         array(
            // //             'parent' => $p_term_id,
            // //             'hide_empty' => false,
            // //         ),
            // //     );
            // //     $query .= " AND wp_terms.term_id IN ".array_column($p_terms, 'term_id')."";
            // // }
            // $query .= "

// データ取得
// WPから商品情報取得
$productData = $wpdb->get_results($query);

// var_dump($_POST["p_parent_cat"]); // ネットワークで見れる
// var_dump($productData); // ネットワークで見れる

$returnProductData = json_decode(
    json_encode(
        array_values(
            $productData
        )
    ),
    true
);

// 出力方法
// 登録日順
// $result = json_encode(
//     array_values($productData)
// );
// jsonを返却
// if ($contents['outputCsv'] !== true) {
//     header("Content-Type: application/json; charset=utf-8");
//     echo $result;
//     exit;
// }

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
    'item_name_2',
    'item_about_2',
    'item_name_3',
    'item_about_3',
    'item_name_4',
    'item_about_4',
    'item_name_5',
    'item_about_5',
    'item_name_6',
    'item_about_6',
    // カラー1
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
    'color_3d_movie_1',
    'color_3d_movie_thumbnail_1',
    'color_3d_movie_2',
    'color_3d_movie_thumbnail_2',
    'color_youtube_movie',
    // 一覧ページ設定
    'product_display_order',
    'product_image_pc',
    'product_image_sp',
    // 資料
    'document_name_1',
    'document_url_1',
    'document_link_blank_1',
    'document_name_2',
    'document_url_2',
    'document_link_blank_2',
    'document_name_3',
    'document_url_3',
    'document_link_blank_3',
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
    '仕様２ 項目名',
    '仕様２ 概要',
    '仕様３ 項目名',
    '仕様３ 概要',
    '仕様４ 項目名',
    '仕様４ 概要',
    '仕様５ 項目名',
    '仕様５ 概要',
    '仕様６ 項目名',
    '仕様６ 概要',
    // カラー1
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
    '動画・3Dモデル１',
    '動画・3Dモデル１のサムネイル画像',
    '動画・3Dモデル２',
    '動画・3Dモデル２のサムネイル画像',
    'youtube 動画URL',
    // 一覧ページ設定
    '表示順',
    '画像（PC）',
    '画像（スマホ）',
    // 資料
    '資料1 資料名',
    '資料1 資料リンク',
    '資料1 リンクを新規タブで開く',
    '資料2 資料名',
    '資料2 資料リンク',
    '資料2 リンクを新規タブで開く',
    '資料3 資料名',
    '資料3 資料リンク',
    '資料3 リンクを新規タブで開く',
];
// $csvHeader = $csvTarget;

$csvData = [];
foreach ($returnProductData as $index => $productDataValue) {
    foreach ($csvTarget as $csvTargetValue) {
        $csvData[$index][] = strval($productDataValue[$csvTargetValue]);
    }
}
putCsv($csvHeader, $csvData);
