<?php
  const PRODUCT_MAX_NUM = 10;

  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./index.php');
    exit();
  }

  require_once('config.php');
  $link = mysqli_connect($dbserver, $user, $password, $dbname)
    or die('MySQL への接続に失敗しました');
  mysqli_set_charset($link, "utf8")
    or die('文字コードの設定に失敗しました');

  $query = '';
  $query .= 'select * from ' . $_SESSION['user_type'] . ' ';
  $query .= 'where user_id = ' . $_SESSION['user_id'];
  $result = mysqli_query($link, $query)
    or die('問い合わせの実行に失敗しました');
  if(mysqli_num_rows($result) === 0) {
    header('Location: ./index.php');
    exit();
  }
  require_once('./module/common.php');

  $user = null;
  while($row = mysqli_fetch_assoc($result)) {
    $user = $row;
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>ユーザ設定 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/account.css">
  </head>
  <body>
    <?php echo common_header(false, 'ユーザ設定'); ?>
    <section>
      <?php
        echo '<p class="error">';
        switch($_SESSION['update_error']) {
          case '0':
            echo '更新されました。';
            break;
          case '1':
            echo 'このメールアドレスは既に登録されています。';
            break;
          case '2':
            echo '確認パスワードが間違っています。';
            break;
          case '3':
            echo '全てのフォームを入力してください。';
            break;
          default:
            break;
        }
        echo '</p>';
        unset($_SESSION['update_error']);
      ?>
      <form action="./auth/update.php" method="post">
        <input class="text" type="email" name="mail" placeholder="新メールアドレス" value="<?php echo $user['mail']; ?>">
        <input class="text" type="password" name="password" placeholder="新パスワード">
        <input class="text" type="password" name="password2" placeholder="新パスワード(確認)">
        <?php
          if($_SESSION['user_type'] === 'seller') {
            echo '<input class="text" type="text" name="shop_name" placeholder="新店名" value="' . $user['shop_name'] . '">';
          }
        ?>
        <input class="button" type="submit" value="送信">
      </form>
    </section>
    <?php echo common_footer(); ?>
  </body>
</html>
