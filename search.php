<?php
  if(!isset($_POST['keyword']) || $_POST['keyword'] === '') {
    header('Location: ./index.php');
    exit();
  }

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
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Database System 1 | 「<?php echo $_POST['keyword'] ?>」の検索結果</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <form action="./search.php" method="post">
        <input type="text" name="keyword" placeholder="検索" value="<?php echo $_POST['keyword'] ?>">
        <input type="submit" value="検索">
      </form>
      <nav>
        <ul>
          <li>ログアウト</li>
        </ul>
      </nav>
    </header>

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
            echo '<li>';
            echo '<img src="' . $row['image_url'] . '">';
            echo '<h3><a href="./product-detail.php?product_id=' . $row['product_id'] . '">' . $row['name'] . '</a></h3>';
            echo '<span>-' . $row['purchase_date'] . '購入</span>';
            echo '<h4>' . $row['shop_name'] . '</h4>';
            echo '<div>' . $row['price'] . '円</div>';

            $query = '';
            $query .= 'select avg(value) as review from review ';
            $query .= 'where product_id = ' . $row['product_id'] . ' ';

            $review_result = mysqli_query($link, $query)
              or die('問い合わせの実行に失敗しました');
            $review = 0;
            if(mysqli_num_rows($review_result) === 1) {
              while($review_row = mysqli_fetch_assoc($review_result)) {
                $review = (int)$review_row['review'];
              }
            }

            echo '<div>';
            for($i = 0; $i < 5; $i++) {
              if($i < $review) {
                echo '♥';
              } else {
                echo '♡';
              }
            }
            echo '</div>';
            echo '</li>';
          }
        }
      ?>
    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
