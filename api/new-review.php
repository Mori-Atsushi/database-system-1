<?php
  session_start();
  if(isset($_POST['value']) && $_POST['value'] !== ''
    && isset($_POST['title'])
    && isset($_POST['comment'])
  ) {
    require_once('../config.php');
    $link = mysqli_connect($dbserver, $user, $password, $dbname)
      or die('MySQL への接続に失敗しました');
    mysqli_set_charset($link, "utf8")
      or die('文字コードの設定に失敗しました');
    $query = '';
    $query .= 'insert into review(product_id, user_id, value, title, comment) ';
    $query .= 'values("' . $_POST['product_id'] . '", "' . $_SESSION['user_id'] . '", "' . $_POST['value'] . '", "' . $_POST['title'] . '", "' . $_POST['comment'] . '")';
    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    header('Location: ../product-detail.php?product_id=' . $_POST['product_id']);
    exit();
  } else {
    $_SESSION['add_customer_error'] = 3;
    header('Location: ../product-detail.php?product_id=' . $_POST['product_id']);
    exit();
  }
?>
