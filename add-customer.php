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
?>

<!DOCTYPE html>
<html>
  <head>
    <title>利用者追加 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1>利用者追加</h1>
      <nav>
        <ul>
          <li><a href="./index.php">トップに戻る</a></li>
          <li><a href="./user-config.php">ユーザ設定</a></li>
          <li><a href="./auth/logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </header>

    <section>
      <?php
        if(isset($_SESSION['add_customer_error'])) {
          switch($_SESSION['add_customer_error']) {
            case '0':
              echo '<p>追加されました。</p>';
              break;
            case '1':
              echo '<p>このメールアドレスは既に登録されています。</p>';
              break;
            case '2':
              echo '<p>確認パスワードが間違っています。</p>';
              break;
            case '3':
              echo '<p>全てのフォームを入力してください。</p>';
              break;
            default:
              break;
          }
          unset($_SESSION['add_customer_error']);
        }
      ?>
      <form action="./api/regist-customer.php" method="post">
        <input type="email" name="mail" placeholder="メールアドレス">
        <input type="password" name="password" placeholder="パスワード">
        <input type="password" name="password2" placeholder="パスワード(確認)">
        <input type="submit" value="追加">
      </form>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
