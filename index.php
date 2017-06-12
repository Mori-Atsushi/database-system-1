<?php
  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./login.php');
  }
  echo $_SESSION['user_id'] . '<br>';
  echo $_SESSION['user_type'] . '<br>';
?>
