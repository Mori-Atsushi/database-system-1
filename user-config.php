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

  $query = '';
  $query .= 'select * from ' . $_SESSION['user_type'] . ' ';
  $query .= 'where user_id = ' . $_SESSION['user_id'];
  $result = mysqli_query($link, $query)
    or die('問い合わせの実行に失敗しました');
  if(mysqli_num_rows($result) === 0) {
    header('Location: ./index.php');
    exit();
  }

  $user = null;
  while($row = mysqli_fetch_assoc($result)) {
    $user = $row;
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
          case '3':
            echo '<p>全てのフォームを入力してください。</p>';
            break;
          default:
            break;
        }
        unset($_SESSION['update_error']);
      ?>
      <form action="./auth/update.php" method="post">
        <input type="email" name="mail" placeholder="新メールアドレス" value="<?php echo $user['mail']; ?>">
        <input type="password" name="password" placeholder="新パスワード">
        <input type="password" name="password2" placeholder="新パスワード(確認)">
        <?php
          if($_SESSION['user_type'] === 'seller') {
            echo '<input type="text" name="shop_name" placeholder="新店名" value="' . $user['shop_name'] . '">';
          }
        ?>
        <input type="submit" value="送信">
      </form>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
