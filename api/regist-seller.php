<?php
  session_start();
  if(isset($_POST['mail']) && $_POST['mail'] !== ''
    && isset($_POST['password']) && $_POST['password'] !== ''
    && isset($_POST['password2']) && $_POST['password2'] !== ''
    && isset($_POST['shop_name']) && $_POST['shop_name'] !== ''
  ) {
    if($_POST['password'] !== $_POST['password2']) {
      $_SESSION['add_seller_error'] = 2;
      header('Location: ../add-seller.php');
      exit();
    }

    require_once('../config.php');
    $link = mysqli_connect($dbserver, $user, $password, $dbname)
      or die('MySQL への接続に失敗しました');
    mysqli_set_charset($link, "utf8")
      or die('文字コードの設定に失敗しました');

    $userTypes = array('customer', 'seller', 'manager');
    foreach($userTypes as $userType) {
      $query = 'select * from ' . $userType . ' where mail = "' . $_POST['mail'] . '"';
      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      if(mysqli_num_rows($result) === 1) {
        mysqli_close($link);
        $_SESSION['add_seller_error'] = 1;
        header('Location: ../add-seller.php');
        exit();
      }
    }
    $query = 'insert into seller(mail, pass, shop_name) values("' . $_POST['mail'] . '", "' . $_POST['password'] . '", "' . $_POST['shop_name'] . '")';
    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    $_SESSION['add_seller_error'] = 0;
    header('Location: ../add-seller.php');
    exit();
  } else {
    $_SESSION['add_seller_error'] = 3;
    header('Location: ../add-seller.php');
    exit();
  }
?>
