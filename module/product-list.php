<?php
  function product_list($row, $link) {
    $return = '';
    $return .= '<li class="product-li">';
    $return .= '<div class="product-image" style="background-image: url(' . $row['image_url'] . ');"></div>';
    $return .= '<div class="info"><h3><a href="./product-detail.php?product_id=' . $row['product_id'] . '">' . $row['name'] . '</a></h3>';
    if(isset($row['purchase_date'])) {
      $return .= '<span class="date">-' . $row['purchase_date'] . '購入</span>';
    }
    if(isset($row['sell_date'])) {
      $return .= '<span class="date">-' . $row['sell_date'] . '出品</span>';
    }
    $return .= '<h4>' . $row['shop_name'] . '</h4>';
    $return .= '<div class="price">' . $row['price'] . '円</div>';
    $return .= review_heart($row['product_id'], $link);
    $return .= '</div></li>';

    return $return;
  }

  function review_heart($product_id, $link, $view_num = false) {
    $query = '';
    $query .= 'select avg(value) as review from review ';
    $query .= 'where product_id = ' . $product_id . ' ';

    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    $review = 0;
    if(mysqli_num_rows($result) === 1) {
      while($row = mysqli_fetch_assoc($result)) {
        $review = (double)$row['review'];
      }
    }

    $return = '';
    $return .= '<div><span class="review-heart">';
    for($i = 0; $i < 5; $i++) {
      if($i < (int)$review) {
        $return .= '♥';
      } else {
        $return .= '♡';
      }
    }
    $return .= '</span>';
    if($view_num) {
      $return .= '<span>（' . number_format($review, 1) . '/5.0)</span>';
    }
    $return .= '</div>';

    return $return;
  }
?>
