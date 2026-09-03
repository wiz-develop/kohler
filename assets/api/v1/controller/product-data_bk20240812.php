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
$query = "WITH RankedMeta AS (
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
            'item_name',
            'item_about',
            'document_name',
            'document_url',
            'document_link_blank',
            'product_color_name',
            'product_color_code',
            'color_model_number',
            'price_color_non_taxed',
            'price_color_types',
            'price_color_var_num',
            'price_color_non_taxed_var',
            'color_file',
            'color_3d_movie',
            'color_youtube_movie',
            'product_variation_title',
            'variation_name',
            'variation_model_number',
            'price_variation_non_taxed',
            'variation_file',
            'variation_3d_movie',
            'variation_youtube_movie',
            'product_display_order',
            'product_image_pc',
            'product_image_sp'
        )
)
SELECT
    wp_posts.ID AS ID,
    wp_posts.post_title AS post_title,
    wp_posts.post_name AS post_name,
    wp_posts.post_status AS post_status,
    subquery.term_id AS term_id,
    subquery.term_name AS term_name,
    -- 仕様 6種
    MAX(CASE WHEN RankedMeta.meta_key = 'model_number' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS model_number,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_price' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_price,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_merit' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_merit,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_name' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS item_name_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_about' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS item_about_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_name' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS item_name_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_about' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS item_about_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_name' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS item_name_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_about' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS item_about_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_name' AND RankedMeta.rn = 4 THEN RankedMeta.meta_value END) AS item_name_4,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_about' AND RankedMeta.rn = 4 THEN RankedMeta.meta_value END) AS item_about_4,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_name' AND RankedMeta.rn = 5 THEN RankedMeta.meta_value END) AS item_name_5,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_about' AND RankedMeta.rn = 5 THEN RankedMeta.meta_value END) AS item_about_5,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_name' AND RankedMeta.rn = 6 THEN RankedMeta.meta_value END) AS item_name_6,
    MAX(CASE WHEN RankedMeta.meta_key = 'item_about' AND RankedMeta.rn = 6 THEN RankedMeta.meta_value END) AS item_about_6,
    -- 関連資料 3種
    MAX(CASE WHEN RankedMeta.meta_key = 'document_name' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS document_name_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_url' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS document_url_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_link_blank' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS document_link_blank_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_name' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS document_name_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_url' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS document_url_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_link_blank' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS document_link_blank_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_name' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS document_name_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_url' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS document_url_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'document_link_blank' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS document_link_blank_3,
    -- カラー 4種
    -- カラー1
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_name' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_color_name_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_code' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_color_code_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_model_number' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_model_number_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS price_color_non_taxed_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_1_price_color_var_num_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_1_price_color_non_taxed_var_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_1_price_color_var_num_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_1_price_color_non_taxed_var_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_1_color_file_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_1_color_file_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS color_1_color_file_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_1_color_3d_movie_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_1_color_3d_movie_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_youtube_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_1_color_youtube_movie_1,
    -- カラー2
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_name' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS product_color_name_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_code' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS product_color_code_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_model_number' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_model_number_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS price_color_non_taxed_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_2_price_color_var_num_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_2_price_color_non_taxed_var_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_2_price_color_var_num_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_2_price_color_non_taxed_var_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_2_color_file_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_2_color_file_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS color_2_color_file_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_2_color_3d_movie_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_2_color_3d_movie_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_youtube_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_2_color_youtube_movie_1,
    -- カラー3
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_name' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS product_color_name_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_code' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS product_color_code_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_model_number' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS color_model_number_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS price_color_non_taxed_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_3_price_color_var_num_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_3_price_color_non_taxed_var_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_3_price_color_var_num_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_3_price_color_non_taxed_var_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_3_color_file_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_3_color_file_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS color_3_color_file_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_3_color_3d_movie_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_3_color_3d_movie_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_youtube_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_3_color_youtube_movie_1,
    -- カラー4
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_name' AND RankedMeta.rn = 4 THEN RankedMeta.meta_value END) AS product_color_name_4,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_color_code' AND RankedMeta.rn = 4 THEN RankedMeta.meta_value END) AS product_color_code_4,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_model_number' AND RankedMeta.rn = 4 THEN RankedMeta.meta_value END) AS color_model_number_4,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed' AND RankedMeta.rn = 4 THEN RankedMeta.meta_value END) AS price_color_non_taxed_4,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_4_price_color_var_num_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_4_price_color_non_taxed_var_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_var_num' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_4_price_color_var_num_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_color_non_taxed_var' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_4_price_color_non_taxed_var_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_4_color_file_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_4_color_file_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_file' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS color_4_color_file_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_4_color_3d_movie_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_3d_movie' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS color_4_color_3d_movie_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'color_youtube_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS color_4_color_youtube_movie_1,
    -- バリエーション 2種
    MAX(CASE WHEN RankedMeta.meta_key = 'product_variation_title' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_variation_title,
    -- バリエーション1
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_name' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_name_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_model_number' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_model_number_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_variation_non_taxed' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS price_variation_non_taxed_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_file' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_1_variation_file_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_file' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS variation_1_variation_file_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_file' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS variation_1_variation_file_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_3d_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_1_variation_3d_movie_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_3d_movie' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS variation_1_variation_3d_movie_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_youtube_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_1_variation_youtube_movie_1,
    -- バリエーション2
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_name' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS variation_name_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_model_number' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS variation_model_number_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'price_variation_non_taxed' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS price_variation_non_taxed_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_file' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_2_variation_file_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_file' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS variation_2_variation_file_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_file' AND RankedMeta.rn = 3 THEN RankedMeta.meta_value END) AS variation_2_variation_file_3,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_3d_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_2_variation_3d_movie_1,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_3d_movie' AND RankedMeta.rn = 2 THEN RankedMeta.meta_value END) AS variation_2_variation_3d_movie_2,
    MAX(CASE WHEN RankedMeta.meta_key = 'variation_youtube_movie' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS variation_2_variation_youtube_movie_1,
    -- 一覧ページ設定
    MAX(CASE WHEN RankedMeta.meta_key = 'product_display_order' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_display_order,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_image_pc' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_image_pc,
    MAX(CASE WHEN RankedMeta.meta_key = 'product_image_sp' AND RankedMeta.rn = 1 THEN RankedMeta.meta_value END) AS product_image_sp
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
WHERE 
    wp_posts.post_type = 'products' AND wp_posts.post_status != 'auto-draft'
GROUP BY
    wp_posts.ID,
    wp_posts.post_title,
    wp_posts.post_name,
    wp_posts.post_status,
    subquery.term_id,
    subquery.term_name;
";


// $queryConditions = [];

// 条件絞り込み
// $queryConditions[] = 'wp_user_level_keys.meta_value = 0'; // 購読者のみ
// if (isset($queryConditions)) {
//     foreach ($queryConditions as $i => $queryCondition) {
//         if ($i === 0) {
//             $query .= ' WHERE ';
//         }

//         $query .= $queryCondition;

//         if (isset($queryConditions[$i + 1])) {
//             $query .= ' AND ';
//         }
//     }
// }

// データ取得
// WPから商品情報取得
$productData = $wpdb->get_results($query);

// var_dump($query); // ネットワークで見れる
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
    'model_number',
    'product_price',
    'product_merit',
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
    'product_color_name_1',
    'product_color_code_1',
    'color_model_number_1',
    'price_color_non_taxed_1',
    'color_1_price_color_var_num_1',
    'color_1_price_color_non_taxed_var_1',
    'color_1_price_color_var_num_2',
    'color_1_price_color_non_taxed_var_2',
    'color_1_color_file_1',
    'color_1_color_file_2',
    'color_1_color_file_3',
    'color_1_color_3d_movie_1',
    'color_1_color_3d_movie_2',
    'color_1_color_youtube_movie_1',
    // カラー2
    'product_color_name_2',
    'product_color_code_2',
    'color_model_number_2',
    'price_color_non_taxed_2',
    'color_2_price_color_var_num_1',
    'color_2_price_color_non_taxed_var_1',
    'color_2_price_color_var_num_2',
    'color_2_price_color_non_taxed_var_2',
    'color_2_color_file_1',
    'color_2_color_file_2',
    'color_2_color_file_3',
    'color_2_color_3d_movie_1',
    'color_2_color_3d_movie_2',
    'color_2_color_youtube_movie_1',
    // カラー3
    'product_color_name_3',
    'product_color_code_3',
    'color_model_number_3',
    'price_color_non_taxed_3',
    'color_3_price_color_var_num_1',
    'color_3_price_color_non_taxed_var_1',
    'color_3_price_color_var_num_2',
    'color_3_price_color_non_taxed_var_2',
    'color_3_color_file_1',
    'color_3_color_file_2',
    'color_3_color_file_3',
    'color_3_color_3d_movie_1',
    'color_3_color_3d_movie_2',
    'color_3_color_youtube_movie_1',
    // カラー4
    'product_color_name_4',
    'product_color_code_4',
    'color_model_number_4',
    'price_color_non_taxed_4',
    'color_4_price_color_var_num_1',
    'color_4_price_color_non_taxed_var_1',
    'color_4_price_color_var_num_2',
    'color_4_price_color_non_taxed_var_2',
    'color_4_color_file_1',
    'color_4_color_file_2',
    'color_4_color_file_3',
    'color_4_color_3d_movie_1',
    'color_4_color_3d_movie_2',
    'color_4_color_youtube_movie_1',
    // バリエーション
    'product_variation_title',
    // バリエーション1
    'variation_name_1',
    'variation_model_number_1',
    'price_variation_non_taxed_1',
    'variation_1_variation_file_1',
    'variation_1_variation_file_2',
    'variation_1_variation_file_3',
    'variation_1_variation_3d_movie_1',
    'variation_1_variation_3d_movie_2',
    'variation_1_variation_youtube_movie_1',
    // バリエーション2
    'variation_name_2',
    'variation_model_number_2',
    'price_variation_non_taxed_2',
    'variation_2_variation_file_1',
    'variation_2_variation_file_2',
    'variation_2_variation_file_3',
    'variation_2_variation_3d_movie_1',
    'variation_2_variation_3d_movie_2',
    'variation_2_variation_youtube_movie_1',
    'product_display_order',
    'product_image_pc',
    'product_image_sp',
];

// 項目名
// $csvHeader = $csvTarget;
$csvHeader = [
    'ID',
    '商品名',
    '商品のパーマリンク',
    '公開・非公開',
    'カテゴリーのID',
    'カテゴリー名',
    '品番',
    '価格（税抜き）',
    '特長',
    '仕様 項目名1',
    '仕様 概要1',
    '仕様 項目名2',
    '仕様 概要2',
    '仕様 項目名3',
    '仕様 概要3',
    '仕様 項目名4',
    '仕様 概要4',
    '仕様 項目名5',
    '仕様 概要5',
    '仕様 項目名6',
    '仕様 概要6',
    // カラー1
    'カラー1 カラー名',
    'カラー1 カラー設定',
    'カラー1 カラー別品番',
    'カラー1 価格（税抜き）',
    'カラー1 バリエーション別品番1',
    'カラー1 バリエーション別価格（税抜き）1',
    'カラー1 バリエーション別品番2',
    'カラー1 バリエーション別価格（税抜き）2',
    'カラー1 画像・サムネイル1',
    'カラー1 画像・サムネイル2',
    'カラー1 画像・サムネイル3',
    'カラー1 動画(mp4)・3Dモデル(glb・gltf)1',
    'カラー1 動画(mp4)・3Dモデル(glb・gltf)2',
    'カラー1 youtube 動画URL',
    // カラー2
    'カラー2 カラー名',
    'カラー2 カラー設定',
    'カラー2 カラー別品番',
    'カラー2 価格（税抜き）',
    'カラー2 バリエーション別品番1',
    'カラー2 バリエーション別価格（税抜き）1',
    'カラー2 バリエーション別品番2',
    'カラー2 バリエーション別価格（税抜き）2',
    'カラー2 画像・サムネイル1',
    'カラー2 画像・サムネイル2',
    'カラー2 画像・サムネイル3',
    'カラー2 動画(mp4)・3Dモデル(glb・gltf)1',
    'カラー2 動画(mp4)・3Dモデル(glb・gltf)2',
    'カラー2 youtube 動画URL',
    // カラー3
    'カラー3 カラー名',
    'カラー3 カラー設定',
    'カラー3 カラー別品番',
    'カラー3 価格（税抜き）',
    'カラー3 バリエーション別品番1',
    'カラー3 バリエーション別価格（税抜き）1',
    'カラー3 バリエーション別品番2',
    'カラー3 バリエーション別価格（税抜き）2',
    'カラー3 画像・サムネイル1',
    'カラー3 画像・サムネイル2',
    'カラー3 画像・サムネイル3',
    'カラー3 動画(mp4)・3Dモデル(glb・gltf)1',
    'カラー3 動画(mp4)・3Dモデル(glb・gltf)2',
    'カラー3 youtube 動画URL',
    // カラー4
    'カラー4 カラー名',
    'カラー4 カラー設定',
    'カラー4 カラー別品番',
    'カラー4 価格（税抜き）',
    'カラー4 バリエーション別品番1',
    'カラー4 バリエーション別価格（税抜き）1',
    'カラー4 バリエーション別品番2',
    'カラー4 バリエーション別価格（税抜き）2',
    'カラー4 画像・サムネイル1',
    'カラー4 画像・サムネイル2',
    'カラー4 画像・サムネイル3',
    'カラー4 動画(mp4)・3Dモデル(glb・gltf)1',
    'カラー4 動画(mp4)・3Dモデル(glb・gltf)2',
    'カラー4 youtube 動画URL',
    // バリエーション
    'バリエーションタイトル',
    // バリエーション1
    'バリエーション1 バリエーション名',
    'バリエーション1 バリエーション別品番',
    'バリエーション1 価格（税抜き）',
    'バリエーション1 画像・サムネイル1',
    'バリエーション1 画像・サムネイル2',
    'バリエーション1 画像・サムネイル3',
    'バリエーション1 動画(mp4)・3Dモデル(glb・gltf)1',
    'バリエーション1 動画(mp4)・3Dモデル(glb・gltf)2',
    'バリエーション1 youtube 動画URL',
    // バリエーション2
    'バリエーション2 バリエーション名',
    'バリエーション2 バリエーション別品番',
    'バリエーション2 価格（税抜き）',
    'バリエーション2 画像・サムネイル1',
    'バリエーション2 画像・サムネイル2',
    'バリエーション2 画像・サムネイル3',
    'バリエーション2 動画(mp4)・3Dモデル(glb・gltf)1',
    'バリエーション2 動画(mp4)・3Dモデル(glb・gltf)2',
    'バリエーション2 youtube 動画URL',
    // 一覧ページ設定
    '表示順',
    '画像（PC）',
    '画像（スマホ）',
];

$csvData = [];
foreach ($returnProductData as $index => $productDataValue) {
    foreach ($csvTarget as $csvTargetValue) {
        $csvData[$index][] = strval($productDataValue[$csvTargetValue]);
    }
}
putCsv($csvHeader, $csvData);
