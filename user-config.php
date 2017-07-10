<?php
  const PRODUCT_MAX_NUM = 10;

  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./login.php');
    exit();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <form action="./search.php" method="post">
        <input type="text" name="keyword" placeholder="検索">
        <input type="submit" value="検索">
      </form>
      <nav>
        <ul>
          <li><a href="./user-config.php">ユーザ設定</a></li>
          <li><a href="./auth/logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </header>

    <section>
      <?php
        switch($_SESSION['update_error']) {
          case '0':
            echo '<p>更新されました。</p>';
            break;
          case '1':
            echo '<p>このメールアドレスは既に登録されています。</p>';
            break;
          case '2':
            echo '<p>確認パスワードが間違っています。</p>';
            break;
          default:
            break;
        }
        unset($_SESSION['update_error']);
      ?>
      <form action="./auth/update.php" method="post">
        <input type="email" name="mail" placeholder="新メールアドレス">
        <input type="password" name="password" placeholder="新パスワード">
        <input type="password" name="password2" placeholder="新パスワード(確認)">
        <input type="submit" value="送信">
      </form>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
