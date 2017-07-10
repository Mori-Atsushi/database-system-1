<?php
  ini_set('display_errors', 1);
  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./login.php');
  }

  require_once('config.php');
  $link = mysqli_connect($dbserver, $user, $password, $dbname)
    or die('MySQL への接続に失敗しました');
  mysqli_set_charset($link, "utf8")
    or die('文字コードの設定に失敗しました');

  require_once('module/review-heart.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1>購入履歴</h1>
      <nav>
        <ul>
          <li>ログアウト</li>
        </ul>
      </nav>
    </header>

    <section>
      <?php
        $query = '';
        $query .= 'select * from product, purchase, seller ';
        $query .= 'where product.product_id = purchase.product_id ';
        $query .= 'and product.user_id = seller.user_id ';
        $query .= 'and purchase.user_id = ' . $_SESSION['user_id'] . ' ';
        $query .= 'order by purchase.purchase_date desc ';

        $result = mysqli_query($link, $query)
          or die('問い合わせの実行に失敗しました');
        if(mysqli_num_rows($result) === 0) {
          echo '<p>購入履歴はありません</p>';
        } else {
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li>';
            echo '<img src="' . $row['image_url'] . '">';
            echo '<h3><a href="./product-detail.php?product_id=' . $row['product_id'] . '">' . $row['name'] . '</a></h3>';
            echo '<span>-' . $row['purchase_date'] . '購入</span>';
            echo '<h4>' . $row['shop_name'] . '</h4>';
            echo '<div>' . $row['price'] . '円</div>';
            echo review_heart($row['product_id'], $link);
            echo '</li>';
          }
        }
      ?>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
