<?php
  function review_heart($product_id, $link) {
    $query = '';
    $query .= 'select avg(value) as review from review ';
    $query .= 'where product_id = ' . $product_id . ' ';

    $result = mysqli_query($link, $query)
      or die('問い合わせの実行に失敗しました');
    $review = 0;
    if(mysqli_num_rows($result) === 1) {
      while($row = mysqli_fetch_assoc($result)) {
        $review = (int)$row['review'];
      }
    }

    $return = '';
    $return .= '<div>';
    for($i = 0; $i < 5; $i++) {
      if($i < $review) {
        $return .= '♥';
      } else {
        $return .= '♡';
      }
    }
    $return .= '</div>';

    return $return;
  }
?>
