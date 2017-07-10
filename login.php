<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>login | Database System 1</title>
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
        if($_SESSION['login_error']) {
          echo '<p>メールアドレスまたはパスワードが間違っています</p>';
        }
        unset($_SESSION['login_error']);
      ?>
      <form action="./auth.php" method="post">
        <input type="email" name="mail" placeholder="メールアドレス">
        <input type="password" name="password" placeholder="パスワード">
        <input type="submit" value="Login">
      </form>
      <div>or</div>
      <a href="./signup.php">Sign Up</a>
    </section>
    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
