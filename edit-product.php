<?php
  ini_set('display_errors', 1);

  session_start();
  if(!isset($_GET['product_id'])
    || !isset($_SESSION['user_id'])
    || !isset($_SESSION['user_type'])
    || $_SESSION['user_type'] !== 'seller'
  ) {
    header('Location: ./index.php');
    exit();
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
  require_once('./module/common.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>商品編集 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/product.css">
  </head>
  <body>
    <?php echo common_header(false, '商品編集'); ?>
    <section>
      <?php
        echo '<form action="./api/update-product.php" method="post">';
        echo '<div style="display:none;"><input type="text" name="product_id" value="' . $product['product_id'] . '"></div>';
        echo '<div><label for="name">商品名</label>';
        echo '<input class="text" type="text" id="name" name="name" value="' . $product['name'] . '"></div>';
        echo '<div><label for="image_url">画像</label>';
        echo '<input class="text" type="text" id="image_url" name="image_url" value="' . $product['image_url'] . '"></div>';
        echo '<label for="price">値段</label>';
        echo '<div class="union"><input class="union text" type="text" id="price" name="price" value="' . $product['price'] . '"><span>円</span></div>';
        echo '<label for="stock">在庫</label>';
        echo '<div class="union"><input class="text" type="text" id="stock" name="stock" value="' . $product['stock'] . '"><span>個</span></div>';
        echo '<div><label for="comment">説明文</label>';
        echo '<textarea class="text" id="comment" name="comment">' . $product['comment'] . '</textarea></div>';
        echo '<input class="button" type="submit" value="更新">';
        echo '</form>';
      ?>
    </section>
    <?php echo common_footer(); ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
  </body>
</html>
