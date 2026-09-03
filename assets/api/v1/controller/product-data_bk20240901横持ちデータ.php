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
// $query = "SELECT `post_title`, `post_name`, `post_status`, `post_date` FROM `wp_posts` WHERE `post_type` = 'products'
// ";

// $query = "SELECT
//     wp_posts.post_title AS post_title,
//     wp_posts.post_name AS post_name,
//     wp_posts.post_status AS post_status,
//     wp_posts.post_date AS post_date,
//     wp_postmeta.meta_key AS meta_key
//     FROM
//         `wp_posts`
//     LEFT JOIN
//         `wp_postmeta`
//     ON wp_posts.id = wp_postmeta.post_id
//     WHERE
//         wp_posts.post_type = 'products'
// ";

$query = "SELECT
    wp_posts.ID AS ID,
    wp_posts.post_title AS post_title,
    wp_posts.post_name AS post_name,
    wp_posts.post_status AS post_status,
    wp_posts.post_date AS post_date,
    wp_postmeta.meta_key AS meta_key,
    wp_postmeta.meta_value AS meta_value
    FROM
        wp_postmeta pm1
    INNER JOIN (
        SELECT
            post_id,
            max(case meta_key when 'product_image' then meta_value else null end) as アイキャッチ画像,
            max(case meta_key when 'product_image_sp' then meta_value else null end) as アイキャッチ画像（スマホ用）,
            max(case meta_key when 'model_number' then meta_value else null end) as 品番,
            max(case meta_key when 'product_price_non_taxed' then meta_value else null end) as 価格（税抜き）,
            max(case meta_key when 'product_merit' then meta_value else null end) as 特徴,
            max(case meta_key when 'specification_list' then meta_value else null end) as 仕様,
            max(case meta_key when 'item_name' then meta_value else null end) as 仕様（項目名）,
            max(case meta_key when 'item_about' then meta_value else null end) as 仕様（概要）,
            max(case meta_key when 'model_number' then meta_value else null end) as model_number,
            max(case meta_key when 'model_number' then meta_value else null end) as model_number,
        FROM wp_postmeta
        WHERE meta_value NOT LIKE '%{%'
    ) pm2
    INNER JOIN (
        SELECT ID, post_title, post_name, post_status, post_date
        FROM `wp_posts`
    ) p
    ON
        pm1.meta_value = pm2.post_id
        AND pm1.post_id = p.ID
    WHERE pm1.post_id
        IN (
            SELECT ID
            FROM `wp_posts`
            WHERE
                `post_type` = 'products'
                ORDER BY `ID`
        )
        AND pm1.meta_key LIKE 'product_image'
    ORDER BY p.menu_order ASC
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
var_dump($productData); // ネットワークで見れる

// $returnProductData = json_decode(
//     json_encode(
//         array_values(
//             $productData
//         )
//     ),
//     true
// );

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

// // CSVを返却、対象のカラム名
// $csvTarget = [
//     'post_title',
//     // 'excellent_id',
//     // 'mbr_nm',
//     // 'mbr_knm',
//     // 'mbr_bth',
//     // 'login_id',
//     // 'web_member_email',
//     // 'is_valid',
//     // 'created_at',
//     // 'updated_at',
// ];

// // 項目名
// $csvHeader = [
//     '商品名',
//     // 'エクセレント会員ID',
//     // '氏名',
//     // 'フリガナ',
//     // '生年月日',
//     // 'ログインID',
//     // 'メールアドレス',
//     // '状況',
//     // '登録日',
//     // '更新日',
// ];

// $csvData = [];
// foreach ($returnProductData as $index => $productDataValue) {
//     foreach ($csvTarget as $csvTargetValue) {
//         $csvData[$index][] = strval($productDataValue[$csvTargetValue]);
//     }
// }
// putCsv($csvHeader, $csvData);
