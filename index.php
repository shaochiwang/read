<!DOCTYPE html>
<html>
<head>
  <title>Let's Read</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body>
  <h1>Let's Read</h1>
</body>
<?php
  if ( isset($_SESSION['user_id']) ) {
    echo('<p><a href="logout.php">Logout</a></p>'."\n");
  } else {
    echo('<p><a href="login.php">Login</a></p>'."\n");
    echo('<p><a href="register.php">Register</a></p>'."\n");
  }
?>
