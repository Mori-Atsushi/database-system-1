<?php
  const REVIEW_MAX_NUM = 10;

  if(!isset($_GET['product_id'])) {
    header('Location: ./index.php');
    exit();
  }

  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./login.php');
    exit();
  }

  require_once('config.php');
  $link = mysqli_connect($dbserver, $user, $password, $dbname)
    or die('MySQL への接続に失敗しました');
  mysqli_set_charset($link, "utf8")
    or die('文字コードの設定に失敗しました');

  require_once('module/product-list.php');

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
    <title>Database System 1 | <?php echo $product['name']; ?></title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1><?php echo $product['name']; ?></h1>
      <nav>
        <ul>
          <li><a href="./user-config.php">ユーザ設定</a></li>
          <li><a href="./auth/logout.php">ログアウト</a></li>
        </ul>
      </nav>

    <section>
      <?php
        echo '<img src="' . $product['image_url'] . '">';
        echo '<h2>' . $product['name'] . '</h2>';
        echo '<h3>' . $product['shop_name'] . '</h3>';
        switch($_SESSION['user_type']) {
          case 'customer':
            echo '<a href="./purchase?product_id=' . $product['product_id'] . '">購入</a>';
            break;
          case 'seller':
            if($product['user_id'] === $_SESSION['user_id']) {
              echo '<a href="./edit-product.php?product_id=' . $product['product_id'] . '">編集</a>';
            }
            break;
        }
        echo '<span>' . $product['price'] . '円</span>';
        echo '<span>（在庫：' . $product['stock'] . '）</span>';
        echo '<p>' . $product['comment'] . '</p>';
      ?>
    </section>

    <section>
      <h2>レビュー</h2>
      <?php
        echo review_heart($product['product_id'], $link, true);
        switch($_SESSION['user_type']) {
          case 'customer':
            echo '<a href="./new-review?roduct_id=' . $product['prodcut_id'] . '">レビューを書く</a>';
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
        echo '<ul>';
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li>';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<span>（評価：' . $row['value'] . ')</span>';
            echo '<p>' . $row['comment'] . '</p>';
            echo '</li>';
          }
          echo '</ul>';
        }
      ?>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
