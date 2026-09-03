<?php
/**
 * 管理画面内
 * 商品情報一括登録ページ
 */

// クエリなしアクセスを拒否
// if (!$_GET['access_from_admin'] && !$_GET['wp_content_url']) {
//     die;
// }
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/ja.js"></script>

<!-- ローダー -->
<div id="loader" class="position-fixed w-100 h-100 d-none" style="z-index: 999;">
  <div class="d-flex justify-content-center align-items-center h-100">
    <div class="p-4 rounded bg-info text-center">
      <div class="mt-2 spinner-border text-light" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <p class="mt-3 text-light text-small mb-0">処理中...</p>
    </div>
  </div>
</div>

<!-- モーダル 商品データ詳細 -->
<div id="detail-modal-block">
  <button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#detail-modal">Launch</button>

  <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="detail-modal-title" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 700px" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detail-modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div id="confirm-save" style="z-index: 1; background-color: rgba(255,255,255,0.6); display:none;" class="w-100 h-100 position-absolute rounded">
          <div id="confirm-select">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center flex-column">
              <p id="confirm-title"></p>
              <div id="btn-row" class="row"></div>
            </div>
          </div>

          <div id="db-accessing" style="display: none;">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
              <div class="p-4 rounded bg-info text-center">
                <div class="mt-2 spinner-border text-light" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3 text-light text-small mb-0">処理中...</p>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button id="modal-close-btn" type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="admin-data-inquiry p-3">
  <div class="wrap">
    <h1>商品情報一括登録</h1>
  </div>

  <div id="search-box">
    <div class="card p-0" style="max-width: 100%;">
      <div class="card-header">
        商品情報ダウンロード
      </div>
      <div class="card-body">
        <div id="validate-error" class="alert alert-danger d-none" role="alert"></div>
        <form id="API_SearchProducts" action="<?php echo get_stylesheet_directory_uri(); ?>/assets/api/v1/controller/product-data.php" method="post">
          <div class="row mb-2">
            <div class="col-2">カテゴリー</div>
            <?php
            $taxonomy = 'products-cat';
            $p_terms = get_terms(
              $taxonomy,
              array(
                'parent' => 0,
                'hide_empty' => false,
              ),
            );
            ?>
            <div class="col-10">
              <select name="p_parent_cat" class="form-control w-25">
                <option value="0">全商品</option>
                <?php
                if ($p_terms) {
                  foreach ($p_terms as $the_term) {
                    echo '<option value="' . $the_term->term_id . '">' . $the_term->name . '</option>';
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="me-2 float-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-download me-1"></i>CSV出力</button>
          </div>
        </form>
      </div>
    </div>
    <div class="card p-0" style="max-width: 100%;">
      <div class="card-header">
        商品情報更新
      </div>
      <div class="card-body">
        <p>CSV（UTF-8）形式のデータをアップロードしてください。</p>
        <div id="validate-error" class="alert alert-danger d-none" role="alert"></div>
        <form id="API_UpdateProducts" enctype="multipart/form-data" method="post">
          <div class="row mb-2">
            <div class="col-10">
              <input type="file" name="csv_file" accept=".csv">
            </div>
          </div>
          <div class="me-2 float-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-download me-1"></i>アップロードして更新</button>
          </div>
        </form>
        <div id="result"></div>
      </div>
    </div>
  </div>

  <!-- <div id="result-box">
    <table class="mt-3 table table-hover table-user-list bg-light">
      <thead>
        <tr>
          <th scope="col">ページID</th>
          <th scope="col">商品名</th>
          <th scope="col">品番</th>
          <th scope="col">価格（税抜き）</th>
          <th scope="col">カラー</th>
          <th scope="col">バリエーション</th>
          <th scope="col">カテゴリー</th>
          <th scope="col">公開状態</th>
        </tr>
      </thead>
      <tbody id="data-tbody">
      </tbody>
    </table>
  </div> -->
</div>

<script>
  // document.getElementById('API_SearchProducts').addEventListener('submit', function (event) {
  //   event.preventDefault(); // ページ遷移を防ぐ

  //   document.getElementById('loader').classList.remove("d-none");

  //   let formData = new FormData(this); // フォームデータを取得

  //   // 非同期でサーバーにリクエストを送信
  //   fetch('<?php echo get_stylesheet_directory_uri(); ?>/assets/api/v1/controller/product-data.php', {
  //     method: 'POST',
  //     body: formData
  //   })
  //     .then(response => response.text())  // サーバーからのレスポンスをテキストとして取得
  //     .then(result => {
  //       document.getElementById('loader').classList.add("d-none");
  //       // document.getElementById('result').innerHTML = result; // 結果をページに表示
  //     })
  //     .catch(error => {
  //       document.getElementById('loader').classList.add("d-none");
  //       console.error('Error:', error);  // エラーハンドリング
  //       document.getElementById('result').innerHTML = 'ダウンロードに失敗しました。';
  //     });
  // });

  document.getElementById('API_UpdateProducts').addEventListener('submit', function (event) {
    event.preventDefault(); // ページ遷移を防ぐ

    document.getElementById('loader').classList.remove("d-none");

    let formData = new FormData(this); // フォームデータを取得

    // 非同期でサーバーにリクエストを送信
    fetch('<?php echo get_stylesheet_directory_uri(); ?>/assets/api/v1/controller/product-data-update.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.text())  // サーバーからのレスポンスをテキストとして取得
      .then(result => {
        document.getElementById('loader').classList.add("d-none");
        document.getElementById('result').innerHTML = result; // 結果をページに表示
      })
      .catch(error => {
        document.getElementById('loader').classList.add("d-none");
        console.error('Error:', error);  // エラーハンドリング
        document.getElementById('result').innerHTML = 'アップロードに失敗しました。';
      });
  });
</script>