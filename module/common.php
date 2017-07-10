<?php
  function common_header($search = false, $title = null) {
    $return = '';
    $return .= '<header>';
    $return .= '<div class="top"></div>';
    if($search || $title !== null) {
      $return .= '<div class="bar">';
      if($search) {
        $return .= '<form action="./search.php" method="post">';
        $return .= '<input class="text" type="text" name="keyword" placeholder="キーワード">';
        $return .= '<input class="button" type="submit" value="検索">';
        $return .= '</form>';
      } else {
        $return .= ' <h1>' . $title . '</h1>';
      }
      $return .= '<nav>';
      $return .= '<button id="menu-button" class="button menu-button"><span class="menu-button-icon"></span></button>';
      $return .= '<ul>';
      $return .= '<li><a href="./index.php">トップに戻る</a></li>';
      $return .= '<li><a href="./user-config.php">ユーザ設定</a></li>';
      $return .= '<li><a href="./auth/logout.php">ログアウト</a></li>';
      $return .= '</ul>';
      $return .= '</nav>';
      $return .= '</div>';
    } else {
      $return .= '<div class="large">';
      $return .= '<h1>Online Shop</h1>';
      $return .= '<h2>Database System I</h2>';
      $return .= '</div>';
    }
    $return .= '</header>';
    return $return;
  }

  function common_footer() {
    $return = '';
    $return .= '<footer>';
    $return .= '<img src="./image/tsukuba.png">';
    $return .= '<div class="text">University of Tsukuba</div>';
    $return .= '</footer>';
    return $return;
  }
?>
