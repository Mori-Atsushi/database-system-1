<?php
  ini_set('display_errors', 1);
  if(!isset($_GET['product_id'])) {
    header('Location: ./index.php');
    exit();
  }

  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./login.php');
  }

  require_once('config.php');
  $link = mysqli_connect($dbserver, $user, $password, $dbname)
    or die('MySQL への接続に失敗しました');
  mysqli_set_charset($link, "utf8")
    or die('文字コードの設定に失敗しました');

  $query = '';
  $query .= 'select * from product ';
  $query .= 'where product_id = ' . $_GET['product_id'] . ' ';
  $query .= 'and user_id = ' . $_SESSION['user_id'];
  $result = mysqli_query($link, $query)
    or die('問い合わせの実行に失敗しました');
  $product = null;
  if(mysqli_num_rows($result) === 0) {
    header('Location: ./index.php');
    exit();
  } else {
    while($row = mysqli_fetch_assoc($result)) {
      $product = $row;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Database System 1 | 商品編集</title>
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
          <li><a href="./user-config.php">ユーザ設定</a></li>
          <li><a href="./auth/logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </header>

    <section>
      <?php
        echo '<form action="./api/update-product.php" method="post">';
        echo '<div style="display:none;"><input type="text" name="product_id" value="' . $product['product_id'] . '"></div>';
        echo '<div><label for="name">商品名</label>';
        echo '<input type="text" id="name" name="name" value="' . $product['name'] . '"></div>';
        echo '<div><img src="' . $product['image_url'] . '">';
        echo '<label for="image_url">画像</label>';
        echo '<input type="file" id="image_url" name="image_url"></div>';
        echo '<div><label for="price">値段</label>';
        echo '<input type="text" id="price" name="price" value="' . $product['price'] . '">円</div>';
        echo '<div><label for="stock">在庫</label>';
        echo '<input type="text" id="stock" name="stock" value="' . $product['stock'] . '">個</div>';
        echo '<div><label for="comment">説明文</label>';
        echo '<textarea id="comment" name="comment">' . $product['comment'] . '</textarea></div>';
        echo '<input type="submit" value="更新">';
        echo '</form>';
      ?>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
