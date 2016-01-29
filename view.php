<?php
require_once 'pdo.php';
require_once 'util.php';
session_start();

// Make sure the REQUEST parameter is present
if ( ! isset($_GET['review_id']) ) {
    $_SESSION['error'] = "Missing review_id";
    header('Location: main.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?= htmlentities($_SESSION['name']); ?>'s Review View</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body style="padding: 10px; font-family: sans-serif;">
  <h1>Review Details</h1>
  <div id="view-area"><img src="spinner.gif"></div>
  <a href="main.php">Done</a>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.11.4.js"></script>
<script src="js/handlebars.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script id="review-template" type="text/x-handlebars-template">
  <p>Book Title: {{title}}</p>
  <p>Rating: {{rating}}</p>
  <p>Extraction:<br/>{{extraction}}</p>
  <p>Reflection:<br/>{{reflection}}</p>
  <p>Feedback:<br/>{{feedback}}</p>
</script>

<script>
$(document).ready(function(){
    $.getJSON('review.php?review_id=<?= htmlentities($_GET['review_id']) ?>', function(data) {
        window.console && console.log(data);
        source  = $("#review-template").html();
        template = Handlebars.compile(source);
        $('#view-area').replaceWith(template(data.review));
    }).fail( function() { alert('getJSON fail'); } );
});
</script>
</body>
</html>
