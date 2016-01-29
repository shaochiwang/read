<?php
// This script works even if you are not logged in
require_once "protectjson.php";
require_once 'pdo.php';
require_once 'util.php';
header("Content-type: application/json; charset=utf-8");

$stmt = $pdo->prepare('SELECT * FROM Review INNER JOIN Book ON Review.book_id = Book.book_id WHERE user_id = :uid');
$stmt->execute(array( ':uid' => $_SESSION['user_id']));
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo(json_encode($reviews));
?>
