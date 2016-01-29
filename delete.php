<?php

// Make the database connection and leave it in the variable $pdo
require_once 'pdo.php';

session_start();

// If the user is not logged in redirect back to index.php
// with an error
if ( ! isset($_SESSION['user_id']) ) {
    die("ACCESS DENIED");
    exit();
}

// If the user requested cancel go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: main.php');
    exit();
}

// Make sure the REQUEST parameter is present
if ( ! isset($_REQUEST['review_id']) ) {
    $_SESSION['error'] = "Missing review_id";
    header('Location: main.php');
    exit();
}

// Load up the profile in question
$stmt = $pdo->prepare('SELECT * FROM (Review JOIN Book ON Review.book_id = Book.book_id)
  JOIN Rate ON Review.rate_id = Rate.rate_id
  WHERE review_id = :rid AND user_id = :uid');
$stmt->execute(array(
  ':rid' => $_REQUEST['review_id'],
  ':uid' => $_SESSION['user_id']) );
$review = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $review === false ) {
    $_SESSION['error'] = "Could not load review";
    header('Location: main.php');
    exit();
}

// Handle the incoming data
if ( isset($_POST['delete']) ) {

    $stmt = $pdo->prepare('DELETE FROM Review WHERE review_id = :rid AND user_id = :uid');
    $stmt->execute(array(
      ':rid' => $_REQUEST['review_id'],
      ':uid' => $_SESSION['user_id']));
    $_SESSION['success'] = "Review deleted";
    header("Location: main.php");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
  <title><?= htmlentities($_SESSION['name']); ?>'s Review Delete</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body style="padding: 10px; font-family: sans-serif;">
  <?php
  if ( isset($_SESSION['error']) ) {
      echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
  }
  if ( isset($_SESSION['success']) ) {
      echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
      unset($_SESSION['success']);
  }
  ?>
  <h1>Deleteing Review</h1>
  <form method="post" action="delete.php">
    <p>Book Title:
      <?= htmlentities($review['title']); ?>
    </p>
    <p>Rating:
      <?= htmlentities($review['rating']); ?>
    </p>
    <p>Extraction:<br/>
      <?= htmlentities($review['extraction']); ?>
    </p>
    <p>Reflection:<br/>
      <?= htmlentities($review['reflection']); ?>
    </p>
    <p>Feedback:<br/>
      <?= htmlentities($review['feedback']); ?>
    </p>
    <input type="hidden" name="review_id"
    value="<?= htmlentities($_REQUEST['review_id']); ?>"
    />
    <input type="submit" name="delete" value="Delete">
    <input type="submit" name="cancel" value="Cancel">
    </p>
  </form>
</body>
</html>
