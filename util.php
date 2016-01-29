<?php

// a bit of utility code
function validateReview() {
    if ( strlen($_POST['book_title']) == 0 || strlen($_POST['rate_rating']) == 0 ||
         strlen($_POST['extraction']) == 0 || strlen($_POST['reflection']) == 0 ) {
      return "All fields are required";
    } else {
      return true;
    }

}

function loadBook($pdo, $book_id) {
    $stmt = $pdo->prepare('SELECT title FROM Book
        WHERE book_id = :bid');
    $stmt->execute(array( ':bid' => $book_id)) ;
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $title = $row;
    }
    return $title;
}

function loadRate($pdo, $rate_id) {
    $stmt = $pdo->prepare('SELECT rating FROM Rate
        WHERE rate_id = :rid');
    $stmt->execute(array( ':rid' => $rate_id)) ;
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $rating = $row;
    }
    return $rating;
}

function flashMessages() {
    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
    }
}
