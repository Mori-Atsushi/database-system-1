<?php
  ini_set( 'display_errors', 1 );
  if(isset($_POST['name'])
    && isset($_POST['image_url'])
    && isset($_POST['price'])
    && isset($_POST['stock'])
    && isset($_POST['comment'])
  ) {
    session_start();

    require_once('../config.php');
    $link = mysqli_connect($dbserver, $user, $password, $dbname)
      or die('MySQL への接続に失敗しました');
    mysqli_set_charset($link, "utf8")
      or die('文字コードの設定に失敗しました');

    $query = '';
    $query .= 'insert into product(name, image_url, price, stock, comment, sell_date, user_id) ';
    $query .= 'values("' . $_POST['name'] . '", "' . $_POST['image_url'] . '", "' . $_POST['price'] . '", "' . $_POST['stock'] . '", "' . $_POST['comment'] . '", "' . date('Y/m/d') . '", "' . $_SESSION['user_id'] . '")';
    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');

    $query = '';
    $query .= 'select product_id from product ';
    $query .= 'where user_id = ' . $_SESSION['user_id'] . ' ';
    $query .= 'order by product_id desc ';
    $query .= 'limit 1';
    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    while($row = mysqli_fetch_assoc($result)) {
      header('Location: ../product-detail.php?product_id=' . $row['product_id']);
      exit();
    }
  } else {
    header('Location: ../index.php');
    exit();
  }
?>
