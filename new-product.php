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
  require_once('./module/common.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>新規出品 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/product.css">
  </head>
  <body>
    <?php echo common_header(false, '新規出品'); ?>
    <section>
      <?php
        echo '<form action="./api/regist-product.php" method="post">';
        echo '<div style="display:none;"><input type="text" name="product_id"></div>';
        echo '<div><label for="name">商品名</label>';
        echo '<input class="text" type="text" id="name" name="name"></div>';
        echo '<div><label for="image_url">画像</label>';
        echo '<input class="text" type="text" id="image_url" name="image_url"></div>';
        echo '<label for="price">値段</label>';
        echo '<div class="union"><input class="union text" type="text" id="price" name="price"><span>円</span></div>';
        echo '<label for="stock">在庫</label>';
        echo '<div class="union"><input class="text" type="text" id="stock" name="stock"><span>個</span></div>';
        echo '<div><label for="comment">説明文</label>';
        echo '<textarea class="text" id="comment" name="comment"></textarea></div>';
        echo '<input class="button" type="submit" value="更新">';
        echo '</form>';
      ?>
    </section>
    <?php echo common_footer(); ?>
  </body>
</html>
