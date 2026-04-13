<?php

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=review_film_system;charset=utf8mb4',
        'root',
        ''
    ); 

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}
?>