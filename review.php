<?php
if (!isset($_GET['review_id'])) {
	die('Missing required parameter');
}
$review_id = $_GET['review_id'];

require_once "protectjson.php";
require_once 'pdo.php';
require_once 'util.php';
header("Content-type: application/json; charset=utf-8");

$stmt = $pdo->prepare('SELECT * FROM Review WHERE review_id = :rid AND user_id = :uid');
$stmt->execute(array( ':rid' => $review_id, ':uid' => $_SESSION['user_id']));
$review = $stmt->fetch(PDO::FETCH_ASSOC);
if ($review === false) {
    die("Could not load profile");
}

$title = loadBook($pdo, $review['book_id']);
$rating = loadRate($pdo, $review['rate_id']);

$retval = array();
$retval['review'] = $review;
$retval['review']['title'] = $title['title'];
$retval['review']['rating'] = $rating['rating'];

echo(json_encode($retval));
?>
