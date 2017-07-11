<?php
  const REVIEW_MAX_NUM = 10;

  session_start();
  if(!isset($_GET['product_id'])
    || !isset($_SESSION['user_id'])
    || !isset($_SESSION['user_type'])
  ) {
    header('Location: ./index.php');
    exit();
  }

  require_once('config.php');
  $link = mysqli_connect($dbserver, $user, $password, $dbname)
    or die('MySQL への接続に失敗しました');
  mysqli_set_charset($link, "utf8")
    or die('文字コードの設定に失敗しました');

  require_once('./module/product-list.php');
  require_once('./module/common.php');

  $query = '';
  $query .= 'select * from product, seller ';
  $query .= 'where product.user_id = seller.user_id ';
  $query .= 'and product.product_id = "' . $_GET['product_id'] . '" ';
  $result = mysqli_query($link, $query)
    or die('問い合わせの実行に失敗しました');
  if(mysqli_num_rows($result) === 0) {
    header('Location: ./index.php');
    exit();
  }

  $product = null;
  while($row = mysqli_fetch_assoc($result)) {
    $product = $row;
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $product['name']; ?> | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/detail.css">
  </head>
  <body>
    <?php echo common_header(false, $product['name']); ?>
    <section class="cover-image" style="background-image: url(<?php echo $product['image_url']; ?>);">
    </section>
    <section class="main">
      <?php
        echo '<h2>' . $product['name'] . '</h2>';
        echo '<h3>' . $product['shop_name'] . '</h3>';
        switch($_SESSION['user_type']) {
          case 'customer':
            echo '<a class="button mini-button" href="./purchase?product_id=' . $product['product_id'] . '">購入</a>';
            break;
          case 'seller':
            if($product['user_id'] === $_SESSION['user_id']) {
              echo '<a class="button mini-button" href="./edit-product.php?product_id=' . $product['product_id'] . '">編集</a>';
            }
            break;
        }
        echo '<span class="price">' . $product['price'] . '円</span>';
        echo '<span class="stock">（在庫：' . $product['stock'] . '個）</span>';
        echo '<p class="comment">' . $product['comment'] . '</p>';
      ?>
    </section>

    <section>
      <h2>レビュー</h2>
      <?php
        echo review_heart($product['product_id'], $link, true);
        switch($_SESSION['user_type']) {
          case 'customer':
            echo '<a class="button mini-button" href="./new-review?roduct_id=' . $product['prodcut_id'] . '">レビューを書く</a>';
            break;
        }
        $query = '';
        $query .= 'select * from review ';
        $query .= 'where product_id = "' . $product['product_id'] . '" ';
        $query .= 'order by review_id desc ';
        $query .= 'limit ' . REVIEW_MAX_NUM;

        $result = mysqli_query($link, $query)
          or die('問い合わせの実行に失敗しました');
        if(mysqli_num_rows($result) === 0) {
          echo '<p>まだレビューはありません。</p>';
        } else {
        echo '<ul class="review">';
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li>';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<span>（評価：' . $row['value'] . ')</span>';
            echo '<p class="comment">' . $row['comment'] . '</p>';
            echo '</li>';
          }
          echo '</ul>';
        }
      ?>
    </section>

    <div id="purchase-pop" class="pop">
      <div class="card">
        <h2>購入確認</h2>
        <p>数量を記入し、送信ボタンを押してください。<span>（在庫：<?php echo $product['stock']; ?> 個）</span><p>
        <form action="./api/purchase.php" method="post">
          <input class="text" type="text" name="num" placeholder="数量">
          <input style="display: none;" class="text" type="text" name="product_id" value="<?php echo $product['product_id']; ?>">
          <input class="button" type="submit" value="送信">
        </form>
      </div>
    </div>

    <div id="review-pop" class="pop">
      <div class="card">
        <h2>レビュー記入</h2>
        <p>レビューを記入し、送信ボタンを押してください。<span>（評価：0〜5）</span><p>
        <form action="./api/new-review.php" method="post">
          <input class="text" type="text" name="value" placeholder="評価(必須)">
          <input class="text" type="text" name="title" placeholder="タイトル">
          <input class="text" type="text" name="comment" placeholder="コメント">
          <input style="display: none;" class="text" type="text" name="product_id" value="<?php echo $product['product_id']; ?>">
          <input class="button" type="submit" value="送信">
        </form>
      </div>
    </div>

    <?php echo common_footer(); ?>
  </body>
</html>
