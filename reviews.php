<?php
session_start();
include 'Includes/DatabaseConnection.php';
if (!isset($_GET['id'])) {
    header('Location: films.php'); // Không có ID thì đuổi về trang danh sách phim
    exit();
}

$id = $_GET['id'];

$sql1 = 'SELECT name, poster, trailer_url, description FROM film WHERE id=:id';
$stmt1 = $pdo->prepare($sql1);
$stmt1->bindValue(":id", $id);
$stmt1->execute();
$film = $stmt1->fetch();

$sql2 = 'SELECT review.*,
                users.firstname,
                users.lastname,
                users.role
                FROM review
        INNER JOIN users ON review.reviewer_id = users.id
        WHERE review.film_id = :id
        ORDER BY review.created_at DESC';
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(":id", $id);
$stmt2->execute();
$reviews = $stmt2->fetchAll();

$average_rating = 0;
if (count($reviews) > 0) {
    $sum = 0;
    foreach ($reviews as $rev) {
        $sum += $rev['rating'];
    }
    $average_rating = round($sum / count($reviews), 1);
}




ob_start();
include 'Templates/reviews.html.php';

$output = ob_get_clean();

include 'Templates/layout.html.php';
