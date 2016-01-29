<?php
// Make the database connection and leave it in the variable $pdo
require_once 'pdo.php';
require_once 'util.php';
session_start();
unset($_SESSION['name']); // To Log the user out
unset($_SESSION['user_id']); // To Log the user out

// If the user requested cancel go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    exit();
}

function generateHash($password) {
    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return crypt($password, $salt);
    }
}

if ( isset($_POST['uname']) && isset($_POST['email']) &&
     isset($_POST['pass']) ) {

    $password = generateHash($_POST['pass']);
  	$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
  	$stmt = $pdo->prepare($sql);
  	$stmt->execute(array(
  	    ":name" => $_POST['uname'],
  	    ":email" => $_POST['email'],
  	    ":password" => $password
  	));

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register Page</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body style="padding: 10px; font-family: sans-serif;">
  <h1>Please Register</h1>
  <?php
    flashMessages();
  ?>
  <form method="POST" action="register.php">
    <label for="name">Name</label>
    <input type="text" name="uname" id="name"><br/>
    <label for="email">Email</label>
    <input type="text" name="email" id="email"><br/>
    <label for="id_1723">Password</label>
    <input type="password" name="pass" id="id_1723"><br/>
    <input type="submit" value="Register">
    <input type="submit" name="cancel" value="Cancel">
  </form>
</body>
