<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>sign up | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1>Online Shop</h1>
      <h2>Database System I</h2>
    </header>
    <section>
      <?php
        switch($_SESSION['regist_error']) {
          case '1':
            echo '<p>このメールアドレスは既に登録されています</p>';
            break;
          case '2':
            echo '<p>パスワードが異なっています。</p>';
            break;
          default:
            break;
        }
        unset($_SESSION['regist_error']);
      ?>
      <form action="./regist.php" method="post">
        <input type="email" name="mail" placeholder="メールアドレス">
        <input type="password" name="password" placeholder="パスワード">
        <input type="password" name="password2" placeholder="パスワード(確認)">
        <input type="submit" value="Sign Up">
      </form>
      <div>or</div>
      <a href="./login.php">Login</a>
    </section>
    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
