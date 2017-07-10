<?php
  unset($_SESSION['user_id']);
  unset($_SESSION['user_type']);
  header('Location: ../login.php');
  exit();
?>
