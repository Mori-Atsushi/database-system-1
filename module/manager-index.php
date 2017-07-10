<section>
  <h2>販売業者一覧</h2>
  <a href="./add-seller.php">追加</a>
  <ul>
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
          echo '<div>' . $row['shop_name'] . '</div>';
          echo '<spna>ユーザID：' . $row['user_id'] . ' - </span>';
          echo '<spna>' . $row['mail'] . '</span>';
          echo '</li>';
        }
      }
    ?>
  </ul>
  <a href="./seller-list.php">もっと見る</a>
</section>

<section>
  <h2>利用者一覧</h2>
  <a href="./add-customer.php">追加</a>
  <ul>
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
          echo '<div>ユーザID：' . $row['user_id'] . '</div>';
          echo '<spna>' . $row['mail'] . '</span>';
          echo '</li>';
        }
      }
    ?>
  </ul>
  <a href="./customer-list.php">もっと見る</a>
</section>
