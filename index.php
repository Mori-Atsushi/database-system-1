<?php
  const PRODUCT_MAX_NUM = 10;

  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./login.php');
  }

  require_once('config.php');
  $link = mysqli_connect($dbserver, $user, $password, $dbname)
    or die('MySQL への接続に失敗しました');
  mysqli_set_charset($link, "utf8")
    or die('文字コードの設定に失敗しました');
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
      <form action="./search.php" method="post">
        <input type="text" name="mail" placeholder="検索">
        <input type="submit" value="検索">
      </form>
      <nav>
        <ul>
          <li>ログアウト</li>
        </ul>
      </nav>
    </header>

    <section>
      <h2>人気商品</h2>
      <ul>
        <?php
          $query = '';
          $query .= 'select *, count(purchase.purchase_id) from product, purchase ';
          $query .= 'where product.product_id = purchase.product_id ';
          $query .= 'group by product.product_id ';
          $query .= 'order by sum(purchase.value) desc ';
          $query .= 'limit ' . PRODUCT_MAX_NUM;

          $result = mysqli_query($link, $query)
            or die('問い合わせの実行に失敗しました');
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li><a href="./product-detail.php?product_id=' . $row['product_id'] . '">';
            echo '<div>' . $row['name'] . '</div>';
            echo '</a></li>';
          }
        ?>
      </ul>
    </section>

    <section>
      <h2>新着商品</h2>
      <ul>
        <?php
          $query = 'select * from product order by sell_date desc limit ' . PRODUCT_MAX_NUM;
          $result = mysqli_query($link, $query)
            or die('問い合わせの実行に失敗しました');
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li><a href="./product-detail.php?product_id=' . $row['product_id'] . '">';
            echo '<div>' . $row['name'] . '</div>';
            echo '</a></li>';
          }
        ?>
      </ul>
    </section>

    <section>
      <h2>購入履歴</h2>
      <ul>
        <?php
          $query = '';
          $query .= 'select * from product, purchase ';
          $query .= 'where product.product_id = purchase.product_id and purchase.user_id = ' . $_SESSION['user_id'] . ' ';
          $query .= 'order by purchase.purchase_date desc ';
          $query .= 'limit ' . PRODUCT_MAX_NUM;

          $result = mysqli_query($link, $query)
            or die('問い合わせの実行に失敗しました');
          if(mysqli_num_rows($result) === 0) {
            echo '<p>購入履歴はありません</p>';
          } else {
            while($row = mysqli_fetch_assoc($result)) {
              echo '<li><a href="./product-detail.php?product_id=' . $row['product_id'] . '">';
              echo '<div>' . $row['name'] . '</div>';
              echo '<p>' . $row['purchase_date'] . '</p>';
              echo '</a></li>';
            }
          }
        ?>
      </ul>
      <a href="./purchase-history.php">もっと見る</a>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
