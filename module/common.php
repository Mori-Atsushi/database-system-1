<?php
  function common_header() {
    $return = '';
    $return .= '<header>';
    $return .= '<div class="top"></div>';
    $return .= '<div class="large">';
    $return .= '<h1>Online Shop</h1>';
    $return .= '<h2>Database System I</h2>';
    $return .= '</div>';
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