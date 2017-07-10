<?php
  session_start();
  require_once('./module/common.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>ログイン | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <?php echo common_header(); ?>
    <section>
      <?php
        if($_SESSION['login_error']) {
          echo '<p>メールアドレスまたはパスワードが間違っています</p>';
        }
        unset($_SESSION['login_error']);
      ?>
      <form action="./auth/auth.php" method="post">
        <input type="email" name="mail" placeholder="メールアドレス">
        <input type="password" name="password" placeholder="パスワード">
        <input type="submit" value="Login">
      </form>
      <div>or</div>
      <a href="./signup.php">Sign Up</a>
    </section>
    <?php echo common_footer(); ?>
  </body>
</html>
