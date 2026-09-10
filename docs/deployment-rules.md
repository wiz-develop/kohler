# テスト環境・本番環境の反映ルール

## ブランチと環境

- `test`: テスト環境。Meta Pixel を入れない。
- `main`: 本番環境。`header.php` の本番専用 Meta Pixel（ID: `1044493571917966`）を必ず保持する。

## 本番反映

1. 変更を `test` で確認する。
2. 確認済みの変更は、ファイルの丸ごと上書きではなく `test` から `main` へ Git でマージする。
3. `header.php` で競合した場合は、`PRODUCTION ONLY: Meta Pixel Code` の開始・終了マーカーとその間のコードを本番側に残す。
4. 本番反映前にリポジトリ直下で次を実行する。

   ```sh
   ./scripts/verify-environment-head.sh production
   ```

5. 反映後は本番ページの HTML を確認し、Pixel ID が2か所（`script` と `noscript`）だけ存在することを確認する。

## 禁止事項

- `test` の `header.php` を `main` へ丸ごとコピーしない。
- フォルダ単位のアップロードで本番テーマ全体を上書きしない。
- 本番専用ブロックをテスト環境にコピーしない。
- 検査スクリプトまたは CI が失敗した状態で本番反映しない。
