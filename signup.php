<?php
  session_start();
  require_once('./module/common.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>新規登録 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/account.css">
  </head>
  <body>
    <?php echo common_header(); ?>
    <section>
      <?php
        echo '<p class="error">';
        switch($_SESSION['regist_error']) {
          case '1':
            echo 'このメールアドレスは既に登録されています';
            break;
          case '2':
            echo 'パスワードが異なっています。';
            break;
          case '3':
            echo '全てのフォームを入力してください。';
            break;
          default:
            break;
        }
        echo '</p>';
        unset($_SESSION['regist_error']);
      ?>
      <form action="./auth/regist.php" method="post">
        <input class="text" type="email" name="mail" placeholder="メールアドレス">
        <input class="text" type="password" name="password" placeholder="パスワード">
        <input class="text" type="password" name="password2" placeholder="パスワード(確認)">
        <input class="button" type="submit" value="Sign Up">
      </form>
      <div class="or">OR</div>
      <a class="button" href="./login.php">Login</a>
    </section>
    <?php echo common_footer(); ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
  </body>
</html>
