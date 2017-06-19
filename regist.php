<?php
  if(isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password2'])) {
    session_start();
    if($_POST['password'] !== $_POST['password2']) {
      $_SESSION['regist_error'] = 2;
      header('Location: ./signup.php');
      exit();
    }

    require_once('config.php');
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
        $_SESSION['regist_error'] = 1;
        header('Location: ./signup.php');
        exit();
      }
    }
    $query = 'insert into customer(mail, pass) values("' . $_POST['mail'] . '", "' . $_POST['password'] . '")';
    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    require_once('auth.php');
    exit();
  } else {
    header('Location: ./login.php');
    exit();
  }
?>
