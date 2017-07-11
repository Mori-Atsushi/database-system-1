<?php
  session_start();
  if(!isset($_POST['keyword'])
    || $_POST['keyword'] === ''
    || !isset($_SESSION['user_id'])
    || !isset($_SESSION['user_type'])
  ) {
    header('Location: ./index.php');
    exit();
  }

  require_once('config.php');
  $link = mysqli_connect($dbserver, $user, $password, $dbname)
    or die('MySQL への接続に失敗しました');
  mysqli_set_charset($link, "utf8")
    or die('文字コードの設定に失敗しました');

  require_once('./module/product-list.php');
  require_once('./module/common.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $_POST['keyword'] ?>」の検索結果 | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/product-list.css">
  </head>
  <body>
    <?php echo common_header(true, $_POST['keyword']); ?>

    <section>
      <?php
        $query = '';
        $query .= 'select * from product, seller ';
        $query .= 'where product.user_id = seller.user_id ';
        $query .= 'and product.name like "%' . $_POST['keyword'] . '%" ';
        $query .= 'order by product.sell_date desc ';

        $result = mysqli_query($link, $query)
          or die('問い合わせの実行に失敗しました');
        if(mysqli_num_rows($result) === 0) {
          echo '<p>' . $_POST['keyword'] . 'に一致する情報は見つかりませんでした。検索ワードを変えてみてください。</p>';
        } else {
          while($row = mysqli_fetch_assoc($result)) {
            echo product_list($row, $link);
          }
        }
      ?>
    </section>
    <?php echo common_footer(); ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
  </body>
</html>
