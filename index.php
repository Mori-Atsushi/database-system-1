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
  require_once('./module/common.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/top.css">
  </head>
  <body>
    <?php echo common_header(true); ?>

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
    <?php echo common_footer(); ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
  </body>
</html>
