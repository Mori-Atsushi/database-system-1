<?php
  ini_set('display_errors', 1);
  session_start();
  if(!isset($_SESSION['user_id'])
    || !isset($_SESSION['user_type'])
    || $_SESSION['user_type'] !== 'manager'
  ) {
    header('Location: ./index.php');
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
    <title>利用者一覧 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/top.css">
  </head>
  <body>
    <?php echo common_header(false, $title="利用者一覧"); ?>
    <section>
      <ul class="text-list">
      <?php
        $query = 'select * from customer';
        $result = mysqli_query($link, $query)
          or die('問い合わせの実行に失敗しました');
        if(mysqli_num_rows($result) === 0) {
          echo '<p>利用者は1人もいません。</p>';
        } else {
          while($row = mysqli_fetch_assoc($result)) {
            echo '<li>';
            echo '<div class="main-text">ユーザID：' . $row['user_id'] . '</div>';
            echo '<p class="sub-text">' . $row['mail'] . '</p>';
            echo '</li>';
          }
        }
      ?>
      </ul>
    </section>
    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
