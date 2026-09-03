<?php
/**
 * API v1
 *
 * データ操作共通ロジック
 */
date_default_timezone_set('Asia/Tokyo');
if (! function_exists('putCsv')) {
    /**
     * csv出力およびダウンロード処理
     *
     * @param array $header
     * @param array $data
     *
     * @return throw|false|int
     */
    function putCsv($header, $data)
    {
        try {
            //CSV形式で情報をファイルに出力のための準備
            $csvFileName = '/tmp/' . time() . rand() . '.csv';
            $fileName = date('YmdHis') . '.csv';
            $res = fopen($csvFileName, 'w');
            if ($res === false) {
                throw new Exception('ファイルの書き込みに失敗しました。');
            }

            // 項目名先に出力
            mb_convert_variables('SJIS-win', 'UTF-8', $header);
            fputcsv($res, $header);

            // ループしながら出力
            foreach ($data as $index => $dataInfo) {
                // ファイルに書き出しをする
                mb_convert_variables('SJIS-win', 'UTF-8', $dataInfo);
                fputcsv($res, $dataInfo);
            }

            // ファイルを閉じる
            fclose($res);

            // ダウンロード開始

            // ファイルタイプ（csv）
            header('Content-Type: application/octet-stream');

            // ファイル名
            header('Content-Disposition: attachment; filename=' . $fileName);
            // ファイルのサイズ　ダウンロードの進捗状況が表示
            header('Content-Length: ' . filesize($csvFileName));
            header('Content-Transfer-Encoding: binary');
            // ファイルを出力する
            readfile($csvFileName);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
