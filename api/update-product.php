<?php
  ini_set( 'display_errors', 1 );
  if(isset($_POST['product_id'])
    && isset($_POST['name'])
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
    $query .= 'update product ';
    $query .= 'set name = "' . $_POST['name'] . '", ';
    $query .= 'image_url = "' . $_POST['image_url'] . '", ';
    $query .= 'price = "' . $_POST['price'] . '", ';
    $query .= 'stock = "' . $_POST['stock'] . '", ';
    $query .= 'comment = "' . $_POST['comment'] . '" ';
    $query .= 'where user_id = ' . $_SESSION['user_id'] . ' ';
    $query .= 'and product_id = ' . $_POST['product_id'];
    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    header('Location: ../product-detail.php?product_id=' . $_POST['product_id']);
    exit();
  } else {
    header('Location: ../index.php');
    exit();
  }
?>
