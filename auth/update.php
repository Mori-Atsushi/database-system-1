<?php
  ini_set( 'display_errors', 1 );
  if(isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password2'])) {
    session_start();
    if($_POST['password'] !== $_POST['password2']) {
      $_SESSION['update_error'] = 2;
      header('Location: ../user-config.php');
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
        $_SESSION['update_error'] = 1;
        header('Location: ../user-config.php');
        exit();
      }
    }
    $query = '';
    $query .= 'update ' . $_SESSION['user_type'] . ' ';
    $query .= 'set mail = "' . $_POST['mail'] . '", pass = "' . $_POST['password'] . '" ';
    $query .= 'where user_id = ' . $_SESSION['user_id'] . ' ';
    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    $_SESSION['update_error'] = 0;
    header('Location: ../user-config.php');
    exit();
  } else {
    header('Location: ../user-config.php');
    exit();
  }
?>
