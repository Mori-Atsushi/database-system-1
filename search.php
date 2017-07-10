<?php
  if(!isset($_POST['keyword']) || $_POST['keyword'] === '') {
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
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Database System 1 | 「<?php echo $_POST['keyword'] ?>」の検索結果</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <form action="./search.php" method="post">
        <input type="text" name="keyword" placeholder="検索" value="<?php echo $_POST['keyword'] ?>">
        <input type="submit" value="検索">
      </form>
      <nav>
        <ul>
          <li><a href="./user-config.php">ユーザ設定</a></li>
          <li><a href="./auth/logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </header>

    <section>
      <?php
        $query = '';
        $query .= 'select * from product, seller ';
        $query .= 'where product.user_id = seller.user_id ';
        $query .= 'and product.name like "%' . $_POST['keyword'] . '%" ';
        $query .= 'order by product.sell_date desc ';

        $result = mysqli_query($link, $query)
          or die('問い合わせの実行に失敗しました');
        if(mysqli_num_rows($result) === 0) {
          echo '<p>' . $_POST['keyword'] . 'に一致する情報は見つかりませんでした。検索ワードを変えてみてください。</p>';
        } else {
          while($row = mysqli_fetch_assoc($result)) {
            echo product_list($row, $link);
          }
        }
      ?>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
