<?php
  function product_list($row, $link) {
    $return = '';
    $return .= '<li>';
    $return .= '<img src="' . $row['image_url'] . '">';
    $return .= '<h3><a href="./product-detail.php?product_id=' . $row['product_id'] . '">' . $row['name'] . '</a></h3>';
    if($row['purchase_date'] !== null) {
      $return .= '<span>-' . $row['purchase_date'] . '購入</span>';
    }
    $return .= '<h4>' . $row['shop_name'] . '</h4>';
    $return .= '<div>' . $row['price'] . '円</div>';
    $return .= review_heart($row['product_id'], $link);
    $return .= '</li>';

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
    $return .= '<div>';
    for($i = 0; $i < 5; $i++) {
      if($i < (int)$review) {
        $return .= '♥';
      } else {
        $return .= '♡';
      }
    }
    if($view_num) {
      $return .= '<span>（' . number_format($review, 1) . '/5.0)</span>';
    }
    $return .= '</div>';

    return $return;
  }
?>
