<?php // Do not put any HTML above this line
require_once 'pdo.php';
require_once 'util.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title><?= htmlentities($_SESSION['name']); ?>'s Reading Records</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body style="padding: 10px;font-family: sans-serif;">
  <h1><?= htmlentities($_SESSION['name']); ?>'s Reading Records</h1>
  <?php
    flashMessages();

    if ( isset($_SESSION['user_id']) ) {
      echo('<p><a href="logout.php">Logout</a></p>'."\n");
    } else {
      echo('<p><a href="login.php">Login</a></p>'."\n");
    }
  ?>
  <div id="list-area"><img src="spinner.gif"></div>
  <?php
  if ( isset($_SESSION['user_id']) ) {
     echo('<p><a href="form.php">Add</a></p>'."\n");
  }
  ?>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.11.4.js"></script>
<script src="js/handlebars.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script id="list-template" type="text/x-handlebars-template">
  {{#if reviews.length}}
    <p><table border="1">
      <tr>
        <th>Title</th>
        {{#if ../loggedin}}
          <th>Action</th>
        {{/if}}
      </tr>
      {{#each reviews}}
        <tr>
          <td>{{title}}</td>
          {{#if ../loggedin}}
            <td>
              <a href="view.php?review_id={{review_id}}">View</a>
              <a href="form.php?review_id={{review_id}}">Edit</a>
              <a href="delete.php?review_id={{review_id}}">Delete</a>
            </td>
          {{/if}}
        </tr>
      {{/each}}
    </table></p>
  {{/if}}
</script>

<script>
$(document).ready(function(){
    $.getJSON('reviews.php', function(reviews) {
        window.console && console.log(reviews);
        var source  = $("#list-template").html();
        var template = Handlebars.compile(source);
        var context = {};
        context.loggedin =
            <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
        context.reviews = reviews;
        $('#list-area').replaceWith(template(context));
    }).fail( function() { alert('getJSON fail'); } );
});
</script>
</body>
