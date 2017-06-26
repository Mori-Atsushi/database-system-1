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
      <input type="text" name="mail" placeholder="検索">
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
          $query = 'select * from product limit ' . PRODUCT_MAX_NUM;
          $result = mysqli_query($link, $query)
            or die('問い合わせの実行に失敗しました');
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li><a><div>' . $row['name'] . '</div></a></li>';
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
            echo '<li><a><div>' . $row['name'] . '</div></a></li>';
          }
        ?>
      </ul>
    </section>

    <section>
      <h2>購入履歴</h2>
      <ul>
        <?php
          $query = 'select * from product limit ' . PRODUCT_MAX_NUM;
          $result = mysqli_query($link, $query)
            or die('問い合わせの実行に失敗しました');
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li><a><div>' . $row['name'] . '</div></a></li>';
          }
        ?>
      </ul>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
