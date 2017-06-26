<?php
  session_start();
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header('Location: ./login.php');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>login | Database System 1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Database System 2">
    <meta name="author" content="Mori Atsushi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1>Online Shop</h1>
      <h2>Database System I</h2>
    </header>

    <section>

    </section>

    <footer>
      University of Tsukuba
    </footer>
  </body>
</html>
