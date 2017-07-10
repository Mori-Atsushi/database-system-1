<?php
  ini_set('display_errors', 1);
  session_start();
  if(!isset($_SESSION['user_id'])
    || !isset($_SESSION['user_type'])
    || $_SESSION['user_type'] !== 'seller'
  ) {
    header('Location: ./index.php');
    exit();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>新規出品 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1>商品編集</h1>
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
        echo '<form action="./api/regist-product.php" method="post">';
        echo '<div><label for="name">商品名</label>';
        echo '<input type="text" id="name" name="name"></div>';
        echo '<label for="image_url">画像</label>';
        echo '<input type="file" id="image_url" name="image_url"></div>';
        echo '<div><label for="price">値段</label>';
        echo '<input type="text" id="price" name="price">円</div>';
        echo '<div><label for="stock">在庫</label>';
        echo '<input type="text" id="stock" name="stock">個</div>';
        echo '<div><label for="comment">説明文</label>';
        echo '<textarea id="comment" name="comment"></textarea></div>';
        echo '<input type="submit" value="送信">';
        echo '</form>';
      ?>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
