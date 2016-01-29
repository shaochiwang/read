<?php // Do not put any HTML above this line

require_once 'pdo.php';
require_once 'util.php';
session_start();
unset($_SESSION['name']); // To Log the user out
unset($_SESSION['user_id']); // To Log the user out

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    exit();
}

function verify($password, $hashedPassword) {
    return crypt($password, $hashedPassword) == $hashedPassword;
}

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
  if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {

    $_SESSION['error'] = "Email and password are required";
    header("Location: login.php");
    exit();

  } else {

    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ":email" => $_POST['email']
    ));

    $row = $stmt->fetch();

    if (verify($_POST['pass'], $row['password'])) {

        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        // Redirect the browser to autos.php
        header("Location: main.php");
        exit();

    } else {

        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        exit();

    }
  }
}

// Finished silently handling any incoming POST data
// Now it is time to produce output for this page
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body style="padding: 10px; font-family: sans-serif;">
  <h1>Please Log In</h1>
  <?php
    flashMessages();
  ?>
  <form method="POST" action="login.php">
    <label for="email">Email</label>
    <input type="text" name="email" id="email"><br/>
    <label for="id_1723">Password</label>
    <input type="password" name="pass" id="id_1723"><br/>
    <input type="submit" value="Log In">
    <input type="submit" name="cancel" value="Cancel">
  </form>
</body>
