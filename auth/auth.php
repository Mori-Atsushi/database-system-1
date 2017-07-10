<?php
  ini_set( 'display_errors', 1 );
  function setSession($result, $userType) {
    if(mysqli_num_rows($result) === 1) {
      session_start();
      while($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_id'] = $row['user_id'];
      }
      $_SESSION['user_type'] = $userType;
      $_SESSION['login_error'] = FALSE;
      header('Location: ../index.php');
      exit();
    }
  }

  if(isset($_POST['mail']) && isset($_POST['password'])) {
    require_once('../config.php');
    $link = mysqli_connect($dbserver, $user, $password, $dbname)
      or die('MySQL への接続に失敗しました');
    mysqli_set_charset($link, "utf8")
      or die('文字コードの設定に失敗しました');

    $userTypes = array('customer', 'seller', 'manager');
    foreach($userTypes as $userType) {
      $query = 'select * from ' . $userType . ' where mail = "' . $_POST['mail'] . '" and pass = "' . $_POST['password'] . '"';
      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      setSession($result, $userType);
    }
    mysqli_close($link);
    session_start();
    $_SESSION['login_error'] = TRUE;
    header('Location: ../login.php');
    exit();
  } else {
    header('Location: ../login.php');
    exit();
  }
?>
