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

// // Look through the POST data and return true or error msg
// function validatePos() {
//     for($i=1; $i<=9; $i++) {
//         if ( ! isset($_POST['year'.$i]) ) continue;
//         if ( ! isset($_POST['desc'.$i]) ) continue;
//         $year = $_POST['year'.$i];
//         $desc = $_POST['desc'.$i];
//         if ( strlen($year) == 0 || strlen($desc) == 0 ) {
//             return "All fields are required";
//         }
//
//         if ( ! is_numeric($year) ) {
//             return "Position year must be numeric";
//         }
//     }
//     return true;
// }
//
// // Look through the POST data and return true or error msg
// function validateEdu() {
//     for($i=1; $i<=9; $i++) {
//         if ( ! isset($_POST['edu_year'.$i]) ) continue;
//         if ( ! isset($_POST['edu_school'.$i]) ) continue;
//         $year = $_POST['edu_year'.$i];
//         $school = $_POST['edu_school'.$i];
//         if ( strlen($year) == 0 || strlen($school) == 0 ) {
//             return "All fields are required";
//         }
//
//         if ( ! is_numeric($year) ) {
//             return "Education year must be numeric";
//         }
//     }
//     return true;
// }


function loadPos($pdo, $profile_id) {
    $stmt = $pdo->prepare('SELECT * FROM Position
        WHERE profile_id = :prof ORDER BY rank');
    $stmt->execute(array( ':prof' => $profile_id)) ;
    $positions = array();
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $positions[] = $row;
    }
    return $positions;
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


function loadEdu($pdo, $profile_id) {
    $stmt = $pdo->prepare('SELECT year,name FROM Education
        JOIN Institution
            ON Education.institution_id = Institution.institution_id
        WHERE profile_id = :prof ORDER BY rank');
    $stmt->execute(array( ':prof' => $profile_id)) ;
    $educations = array();
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $educations[] = $row;
    }
    return $educations;
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
