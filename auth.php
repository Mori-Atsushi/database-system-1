<?php
  function setSession($result, $userType) {
    session_start();
    $userId = 0;
    while($row = mysqli_fetch_assoc($result)) {
      $uesrId = $row['user_id'];
    }
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_type'] = $userType;
    $_SESSION['login_error'] = FALSE;
  }

  if(isset($_POST['mail']) && isset($_POST['password'])) {
    require_once('config.php');
    $link = mysqli_connect($dbserver, $user, $password, $dbname)
      or die('MySQL への接続に失敗しました');
    mysqli_set_charset($link, "utf8")
      or die('文字コードの設定に失敗しました');

    $userTypes = array('customer', 'seller', 'manager');
    foreach($userTypes as $userType) {
      $query = 'select * from ' . $userType . ' where mail = "' . $_POST['mail'] . '" and pass = "' . $_POST['password'] . '"';
      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      if(mysqli_num_rows($result) == 1) {
        setSession($result, $userType);
        mysqli_close($link);
        header('Location: ./index.php');
      }
    }
    mysqli_close($link);
    session_start();
    $_SESSION['login_error'] = TRUE;
    header('Location: ./login.php');
  } else {
    header('Location: ./login.php');
  }
?>
