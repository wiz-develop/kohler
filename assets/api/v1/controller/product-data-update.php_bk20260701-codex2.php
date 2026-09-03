<?php
/**
 * 商品情報更新 API v1
 *
 * 2026/05/19 改修
 *  - 削除：仕様2〜6（item_name_2〜6 / item_about_2〜6）
 *  - 削除：動画・3Dモデル1/2 と各サムネイル
 *           （color_3d_movie_1/2, color_3d_movie_thumbnail_1/2）
 *  - 追加：資料4〜7（document_list の weight=3〜6）
 *  - CSV列の並び替えに合わせて列番号（$data[xx]）を全面的に再割当て
 *
 * ▼修正後のCSV列番号と内容 (0始まり)
 *  0 : ID                              1 : 商品名                       2 : 商品のパーマリンク
 *  3 : 公開・非公開                    4 : カテゴリーのID               5 : カテゴリー名
 *  6 : 品番                            7 : 希望小売価格(税抜)           8 : 特長
 *  9 : スパウト                       10 : 対応穴径                    11 : 吐水
 * 12 : 回転範囲                       13 : 節湯                        14 : JWWA
 * 15 : サイズ                         16 : 材質                        17 : 設置タイプ
 * 18 : 排水口径                       19 : オーバーフロー              20 : 付属品
 * 21 : 引き棒                         22 : ボウル深さ                  23 : 水栓取付穴径
 * 24 : 容量                           25 : 重量                        26 : 備考1
 * 27 : 備考2                          28 : 仕様1 項目名                29 : 仕様1 概要
 * 30 : カラー名                       31 : カラー設定                  32 : カラー別希望小売価格
 * 33 : 画像1                          34 : 画像2                       35 : 画像3
 * 36 : 画像4                          37 : 画像5                       38 : 画像6
 * 39 : 画像7                          40 : youtube動画URL              41 : 表示順
 * 42 : 画像（PC）                     43 : 画像（スマホ）
 * 44 : 資料1 資料名                   45 : 資料1 資料リンク            46 : 資料1 新規タブ
 * 47 : 資料2 資料名                   48 : 資料2 資料リンク            49 : 資料2 新規タブ
 * 50 : 資料3 資料名                   51 : 資料3 資料リンク            52 : 資料3 新規タブ
 * 53 : 資料4 資料名                   54 : 資料4 資料リンク            55 : 資料4 新規タブ
 * 56 : 資料5 資料名                   57 : 資料5 資料リンク            58 : 資料5 新規タブ
 * 59 : 資料6 資料名                   60 : 資料6 資料リンク            61 : 資料6 新規タブ
 * 62 : 資料7 資料名                   63 : 資料7 資料リンク            64 : 資料7 新規タブ
 */
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME'])[0];
require_once($parse_uri . 'wp-load.php');
global $wpdb;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    // ファイルが正しくアップロードされたかチェック
    if ($_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $csv_file = $_FILES['csv_file']['tmp_name'];

        // CSV処理ロジックをここに記述
        process_csv_and_update($csv_file);

        // 処理が成功した場合
        echo '<span class="text-primary">商品情報を更新しました。公開ページをご確認ください。</span>';
    } else {
        // エラーが発生した場合
        echo '<span class="text-danger">ファイルのアップロードに失敗しました。エラーコード：' . $_FILES['csv_file']['error'] . '</span>';
    }
} else {
    echo '<span class="text-danger">ファイルが選択されていません。</span>';
}

function process_csv_and_update($csv_file)
{
    // CSVファイルを開く
    if (($handle = fopen($csv_file, "r")) !== FALSE) {
        // ヘッダーを読み込む
        $header = normalize_csv_row(fgetcsv($handle, 10000, ","));

        // 商品ごとのリピーターフィールドを扱うための一時配列
        $products = [];
        $products_color_data = [];

        // 前回のループでの id,permalink を保存する変数
        $previous_id = '';
        $previous_permalink = '';

        $index_csv = 0;
        $index = 0;
        $index_color = 0;

        // データの処理
        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
            $data = normalize_csv_row($data);
            // CSVの各行を取得
            $id = (isset($data[0])) ? $data[0] : '';  // 投稿ID
            if ($id != 'ID') {
                if (empty($id)) { // $data[0] が空の場合、仮の値を設定
                    $id = 'new_' . uniqid(); // 仮のIDをユニークIDで生成
                }
                $permalink = (isset($data[2])) ? $data[2] : '';

                // 前回のループの $permalink と同じかどうか判別
                if ($id == $previous_id || $permalink == $previous_permalink) {
                    $id = $previous_id;
                    $index_color++;
                } else {
                    $index++;
                    $index_color = 0;

                    $title       = (isset($data[1]))  ? $data[1]  : '';
                    $post_status = (isset($data[3]))  ? $data[3]  : '';
                    $term_id     = (isset($data[4]))  ? $data[4]  : '';

                    // カスタムフィールド（商品共通スペック）
                    $product_price = (isset($data[7]))  ? $data[7]  : ''; // 希望小売価格(税抜)
                    $product_merit = (isset($data[8]))  ? $data[8]  : ''; // 特長
                    $item_1        = (isset($data[9]))  ? $data[9]  : ''; // スパウト
                    $item_2        = (isset($data[10])) ? $data[10] : ''; // 対応穴径
                    $item_3        = (isset($data[11])) ? $data[11] : ''; // 吐水
                    $item_4        = (isset($data[12])) ? $data[12] : ''; // 回転範囲 ※旧バグ修正：data[12]を参照
                    $item_5        = (isset($data[13])) ? $data[13] : ''; // 節湯
                    $item_6        = (isset($data[14])) ? $data[14] : ''; // JWWA
                    $item_7        = (isset($data[15])) ? $data[15] : ''; // サイズ
                    $item_8        = (isset($data[16])) ? $data[16] : ''; // 材質
                    $item_9        = (isset($data[17])) ? $data[17] : ''; // 設置タイプ
                    $item_10       = (isset($data[18])) ? $data[18] : ''; // 排水口径
                    $item_11       = (isset($data[19])) ? $data[19] : ''; // オーバーフロー
                    $item_12       = (isset($data[20])) ? $data[20] : ''; // 付属品
                    $item_13       = (isset($data[21])) ? $data[21] : ''; // 引き棒
                    $item_14       = (isset($data[22])) ? $data[22] : ''; // ボウル深さ
                    $item_15       = (isset($data[23])) ? $data[23] : ''; // 水栓取付穴径
                    $item_16       = (isset($data[24])) ? $data[24] : ''; // 容量
                    $item_17       = (isset($data[25])) ? $data[25] : ''; // 重量
                    $item_18       = (isset($data[26])) ? $data[26] : ''; // 備考1
                    $item_19       = (isset($data[27])) ? $data[27] : ''; // 備考2

                    // 仕様1のみ（仕様2〜6は廃止）
                    $item_name_1   = (isset($data[28])) ? $data[28] : ''; // 仕様1 項目名
                    $item_about_1  = (isset($data[29])) ? $data[29] : ''; // 仕様1 概要

                    // 一覧ページ設定
                    $product_display_order = (isset($data[41])) ? $data[41] : ''; // 表示順
                    $product_image_pc      = (isset($data[42])) ? $data[42] : ''; // 画像（PC）
                    $product_image_sp      = (isset($data[43])) ? $data[43] : ''; // 画像（スマホ）

                    $products[$index]['post_data'] = array(
                        'ID'          => $id,
                        'post_title'  => $title,
                        'post_status' => $post_status,
                        'post_name'   => $permalink,
                        'post_type'   => 'products',
                    );

                    // タクソノミーデータ（タームID）を追加
                    $products[$index]['term_id'] = $term_id;

                    // カスタムフィールドを追加
                    $products[$index]['field']['product_price'] = $product_price;
                    $products[$index]['field']['product_merit'] = $product_merit;
                    $products[$index]['field']['item_1']        = $item_1;
                    $products[$index]['field']['item_2']        = $item_2;
                    $products[$index]['field']['item_3']        = $item_3;
                    $products[$index]['field']['item_4']        = $item_4;
                    $products[$index]['field']['item_5']        = $item_5;
                    $products[$index]['field']['item_6']        = $item_6;
                    $products[$index]['field']['item_7']        = $item_7;
                    $products[$index]['field']['item_8']        = $item_8;
                    $products[$index]['field']['item_9']        = $item_9;
                    $products[$index]['field']['item_10']       = $item_10;
                    $products[$index]['field']['item_11']       = $item_11;
                    $products[$index]['field']['item_12']       = $item_12;
                    $products[$index]['field']['item_13']       = $item_13;
                    $products[$index]['field']['item_14']       = $item_14;
                    $products[$index]['field']['item_15']       = $item_15;
                    $products[$index]['field']['item_16']       = $item_16;
                    $products[$index]['field']['item_17']       = $item_17;
                    $products[$index]['field']['item_18']       = $item_18;
                    $products[$index]['field']['item_19']       = $item_19;
                    $products[$index]['field']['item_name_1']   = $item_name_1;
                    $products[$index]['field']['item_about_1']  = $item_about_1;
                    $products[$index]['field']['product_display_order'] = $product_display_order;
                    $products[$index]['field']['product_image_pc']      = $product_image_pc;
                    $products[$index]['field']['product_image_sp']      = $product_image_sp;

                    // 資料1〜7
                    $document_name_1       = (isset($data[44])) ? $data[44] : '';
                    $document_url_1        = (isset($data[45])) ? $data[45] : '';
                    $document_link_blank_1 = (isset($data[46])) ? $data[46] : '';
                    $document_name_2       = (isset($data[47])) ? $data[47] : '';
                    $document_url_2        = (isset($data[48])) ? $data[48] : '';
                    $document_link_blank_2 = (isset($data[49])) ? $data[49] : '';
                    $document_name_3       = (isset($data[50])) ? $data[50] : '';
                    $document_url_3        = (isset($data[51])) ? $data[51] : '';
                    $document_link_blank_3 = (isset($data[52])) ? $data[52] : '';
                    $document_name_4       = (isset($data[53])) ? $data[53] : '';
                    $document_url_4        = (isset($data[54])) ? $data[54] : '';
                    $document_link_blank_4 = (isset($data[55])) ? $data[55] : '';
                    $document_name_5       = (isset($data[56])) ? $data[56] : '';
                    $document_url_5        = (isset($data[57])) ? $data[57] : '';
                    $document_link_blank_5 = (isset($data[58])) ? $data[58] : '';
                    $document_name_6       = (isset($data[59])) ? $data[59] : '';
                    $document_url_6        = (isset($data[60])) ? $data[60] : '';
                    $document_link_blank_6 = (isset($data[61])) ? $data[61] : '';
                    $document_name_7       = (isset($data[62])) ? $data[62] : '';
                    $document_url_7        = (isset($data[63])) ? $data[63] : '';
                    $document_link_blank_7 = (isset($data[64])) ? $data[64] : '';

                    // 資料情報を追加（リピーター）
                    $products[$index]['field']['document_list'][0] = array(
                        "document_name"       => $document_name_1,
                        "document_url"        => $document_url_1,
                        "document_link_blank" => $document_link_blank_1,
                    );
                    $products[$index]['field']['document_list'][1] = array(
                        "document_name"       => $document_name_2,
                        "document_url"        => $document_url_2,
                        "document_link_blank" => $document_link_blank_2,
                    );
                    $products[$index]['field']['document_list'][2] = array(
                        "document_name"       => $document_name_3,
                        "document_url"        => $document_url_3,
                        "document_link_blank" => $document_link_blank_3,
                    );
                    $products[$index]['field']['document_list'][3] = array(
                        "document_name"       => $document_name_4,
                        "document_url"        => $document_url_4,
                        "document_link_blank" => $document_link_blank_4,
                    );
                    $products[$index]['field']['document_list'][4] = array(
                        "document_name"       => $document_name_5,
                        "document_url"        => $document_url_5,
                        "document_link_blank" => $document_link_blank_5,
                    );
                    $products[$index]['field']['document_list'][5] = array(
                        "document_name"       => $document_name_6,
                        "document_url"        => $document_url_6,
                        "document_link_blank" => $document_link_blank_6,
                    );
                    $products[$index]['field']['document_list'][6] = array(
                        "document_name"       => $document_name_7,
                        "document_url"        => $document_url_7,
                        "document_link_blank" => $document_link_blank_7,
                    );
                }

                // 品番
                $full_model_number = (isset($data[6])) ? $data[6] : ''; // model_number-color_model_number
                if (empty($full_model_number)) {
                    break;
                }
                $parts = explode('-', $full_model_number, 3); // 最初の2つのハイフンで分割

                // 配列の要素数をチェックしてから値をセット
                $model_number = "";
                $color_model_number = $full_model_number;

                if ($permalink !== $previous_permalink) {
                    $products[$index]['field']['model_number'] = $model_number;
                }

                // カラー情報（動画・3Dモデル関連は廃止）
                $product_color_name    = (isset($data[30])) ? $data[30] : ''; // カラー名
                $product_color_code    = (isset($data[31])) ? $data[31] : ''; // カラー設定
                $price_color_non_taxed = (isset($data[32])) ? $data[32] : ''; // カラー別希望小売価格(税抜)
                $color_file_1          = (isset($data[33])) ? $data[33] : ''; // 画像1
                $color_file_2          = (isset($data[34])) ? $data[34] : ''; // 画像2
                $color_file_3          = (isset($data[35])) ? $data[35] : ''; // 画像3
                $color_file_4          = (isset($data[36])) ? $data[36] : ''; // 画像4
                $color_file_5          = (isset($data[37])) ? $data[37] : ''; // 画像5
                $color_file_6          = (isset($data[38])) ? $data[38] : ''; // 画像6
                $color_file_7          = (isset($data[39])) ? $data[39] : ''; // 画像7
                $color_youtube_movie   = (isset($data[40])) ? $data[40] : ''; // youtube 動画URL

                // カラー情報を追加
                $products_color_data = array(
                    "product_color_name"    => $product_color_name,
                    "product_color_code"    => $product_color_code,
                    "color_model_number"    => $color_model_number,
                    "price_color_non_taxed" => $price_color_non_taxed,
                    "color_file_1"          => $color_file_1,
                    "color_file_2"          => $color_file_2,
                    "color_file_3"          => $color_file_3,
                    "color_file_4"          => $color_file_4,
                    "color_file_5"          => $color_file_5,
                    "color_file_6"          => $color_file_6,
                    "color_file_7"          => $color_file_7,
                    "color_youtube_movie"   => $color_youtube_movie,
                );

                $products[$index]['field']['product_colors'][$index_color] = $products_color_data;

                $previous_id = $id;
                $previous_permalink = $permalink; // 現在の $permalink を次のループの比較用に保存

                $index_csv++;
            }
        }
        fclose($handle);

        $previous_save_id = '';

        // 商品データを保存
        foreach ($products as $product) {

            $post_data = $product['post_data'];
            $product_data = $product['field'];

            // 投稿IDがある場合は更新、ない場合は新規作成

            // 投稿が存在する場合
            if (strpos($post_data['ID'], 'new_') === false) {
                // 投稿の更新
                $return_id = wp_update_post($post_data);

                // 新規作成された投稿にカスタムフィールドを保存
                if ($return_id) {
                    CFS()->save($product_data, array('ID' => $return_id));

                    // ターム（products-cat）の紐付け
                    if (!empty($product['term_id'])) {
                        $terms = get_term($product['term_id'] , 'products-cat');
                        wp_set_object_terms($return_id, $terms->slug, 'products-cat');
                    }
                }
            } else {
                if ($post_data['ID'] === $previous_save_id) { // 前行で投稿を登録済の場合
                    // カスタムフィールドの保存 (リピーターフィールド)
                    CFS()->save($product_data, array('ID' => $previous_save_id));
                } else {
                    $post_data_insert = $post_data;
                    if ($post_data_insert['ID']) {
                        unset($post_data_insert['ID']);
                    }

                    // 新しい投稿を作成
                    $return_id = wp_insert_post($post_data_insert);
                    if ($return_id) {
                        // カスタムフィールドの保存 (リピーターフィールド)
                        CFS()->save($product_data, array('ID' => $return_id));

                        // ターム（products-cat）の紐付け
                        if (!empty($product['term_id'])) {
                            $terms = get_term($product['term_id'] , 'products-cat');
                            wp_set_object_terms($return_id, $terms->slug, 'products-cat');
                        }
                    }
                }
            }
            $previous_save_id = $post_data['ID'];
        }
    }
}

function normalize_csv_row($row)
{
    if (!is_array($row)) {
        return $row;
    }

    foreach ($row as $index => $value) {
        if ($value === null || $value === '') {
            continue;
        }

        $encoding = mb_detect_encoding($value, ['UTF-8', 'SJIS-win', 'SJIS', 'EUC-JP', 'ASCII'], true);
        if ($encoding && $encoding !== 'UTF-8' && $encoding !== 'ASCII') {
            $value = mb_convert_encoding($value, 'UTF-8', $encoding);
        } elseif (!mb_check_encoding($value, 'UTF-8')) {
            $value = mb_convert_encoding($value, 'UTF-8', 'SJIS-win');
        }

        $row[$index] = preg_replace('/^\xEF\xBB\xBF/', '', $value);
    }

    return $row;
}
