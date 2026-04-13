<?php
session_start();
include 'Includes/DatabaseConnection.php';


if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    $film_id = $_POST['film_id'];


    $sql = "DELETE FROM film WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->BindValue(':id', $film_id);
    $stmt->execute();
    header('Location: films.php');
    exit();
} else {
    echo 'You are not an admin';
}
