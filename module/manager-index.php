<section>
  <h2>販売業者一覧</h2>
  <a class="button mini-button" href="./add-seller.php">追加</a>
  <ul class="text-list">
    <?php
      $query = '';
      $query .= 'select * from seller ';
      $query .= 'limit ' . PRODUCT_MAX_NUM;

      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      if(mysqli_num_rows($result) === 0) {
        echo '<p>販売業者は1人もいません。</p>';
      } else {
        while($row = mysqli_fetch_assoc($result)) {
          echo '<li>';
          echo '<div class="main-text">' . $row['shop_name'] . '</div>';
          echo '<p class="sub-text"><spna>ユーザID：' . $row['user_id'] . ' - </span>';
          echo '<spna>' . $row['mail'] . '</span><p>';
          echo '</li>';
        }
      }
    ?>
  </ul>
  <a class="read-more" href="./seller-list.php">もっと見る</a>
</section>

<section>
  <h2>利用者一覧</h2>
  <a class="button mini-button" href="./add-customer.php">追加</a>
  <ul class="text-list">
    <?php
      $query = '';
      $query .= 'select * from customer ';
      $query .= 'limit ' . PRODUCT_MAX_NUM;

      $result = mysqli_query($link, $query)
        or die('問い合わせの実行に失敗しました');
      if(mysqli_num_rows($result) === 0) {
        echo '<p>利用者は1人もいません。</p>';
      } else {
        while($row = mysqli_fetch_assoc($result)) {
          echo '<li>';
          echo '<div class="main-text">ユーザID：' . $row['user_id'] . '</div>';
          echo '<p class="sub-text">' . $row['mail'] . '</p>';
          echo '</li>';
        }
      }
    ?>
  </ul>
  <a class="read-more" href="./customer-list.php">もっと見る</a>
</section>
