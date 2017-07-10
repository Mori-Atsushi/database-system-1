<?php
  const PRODUCT_MAX_NUM = 10;

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
        <input type="text" name="keyword" placeholder="検索">
        <input type="submit" value="検索">
      </form>
      <nav>
        <ul>
          <li><a href="./user-config.php">ユーザ設定</a></li>
          <li><a href="./auth/logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </header>

    <?php
      switch($_SESSION['user_type']) {
        case 'customer':
          include('./module/user-index.php');
          break;
        case 'seller':
          include('./module/seller-index.php');
          break;
        case 'manager':
          include('./module/manager-index.php');
          break;
      }
    ?>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
