<section class="side-scroll">
  <h2>人気商品（あなたの出品）</h2>
  <ul>
    <?php
      $query = '';
      $query .= 'select * from product, purchase ';
      $query .= 'where product.product_id = purchase.product_id ';
      $query .= 'and product.user_id = ' . $_SESSION['user_id'] . ' ';
      $query .= 'group by product.product_id ';
      $query .= 'order by sum(purchase.value) desc ';
      $query .= 'limit ' . PRODUCT_MAX_NUM;

      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      while($row = mysqli_fetch_assoc($result)) {
        echo '<li style="background-image: url(' . $row['image_url'] . '); ">';
        echo '<a href="./product-detail.php?product_id=' . $row['product_id'] . '">';
        echo '<div>' . $row['name'] . '</div>';
        echo '</a></li>';
      }
    ?>
  </ul>
</section>

<section class="side-scroll">
  <h2>最近の注文（あなたの出品）</h2>
  <ul>
    <?php
      $query = '';
      $query .= 'select * from product, purchase ';
      $query .= 'where product.product_id = purchase.product_id ';
      $query .= 'group by product.product_id ';
      $query .= 'order by purchase.purchase_date desc ';
      $query .= 'limit ' . PRODUCT_MAX_NUM;

      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      while($row = mysqli_fetch_assoc($result)) {
        echo '<li style="background-image: url(' . $row['image_url'] . '); ">';
        echo '<a href="./product-detail.php?product_id=' . $row['product_id'] . '">';
        echo '<div>' . $row['name'] . '</div>';
        echo '</a></li>';
      }
    ?>
  </ul>
</section>

<section>
  <h2>出品履歴</h2>
  <a class="button mini-button" href="./new-product.php">新規出品</a>
  <ul class="text-list">
    <?php
      $query = '';
      $query .= 'select * from product ';
      $query .= 'where product.user_id = ' . $_SESSION['user_id'] . ' ';
      $query .= 'order by product.sell_date desc ';
      $query .= 'limit ' . PRODUCT_MAX_NUM;

      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      if(mysqli_num_rows($result) === 0) {
        echo '<p>購入履歴はありません。</p>';
      } else {
        while($row = mysqli_fetch_assoc($result)) {
          echo '<li><a href="./product-detail.php?product_id=' . $row['product_id'] . '">';
          echo '<div class="main-text">' . $row['name'] . '</div>';
          echo '<p class="sub-text">' . $row['sell_date'] . '</p>';
          echo '</a></li>';
        }
      }
    ?>
  </ul>
  <a class="read-more" href="./sell-history.php">もっと見る</a>
</section>
