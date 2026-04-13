<?php
session_start();
include 'Includes/DatabaseConnection.php';

try {
    // Kéo 5 bộ phim mới nhất từ database
    $sql = 'SELECT id, name, poster, director FROM film ORDER BY created_at DESC LIMIT 5';
    $stmt = $pdo->query($sql);
    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get Total Films
    $sql_total_films = 'SELECT COUNT(*) FROM film';
    $total_films = $pdo->query($sql_total_films)->fetchColumn();

    // Get Total Reviews
    $sql_total_reviews = 'SELECT COUNT(*) FROM review';
    $total_reviews = $pdo->query($sql_total_reviews)->fetchColumn();

    // Get Top 5 Latest Reviews
    $sql_latest_reviews = 'SELECT review.rating, review.detail, users.username, film.name AS film_name, review.created_at 
                           FROM review 
                           INNER JOIN users ON review.reviewer_id = users.id 
                           INNER JOIN film ON review.film_id = film.id 
                           ORDER BY review.created_at DESC 
                           LIMIT 5';
    $latest_reviews = $pdo->query($sql_latest_reviews)->fetchAll(PDO::FETCH_ASSOC);

    ob_start();
    include 'Templates/home.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $output = 'Database error: ' . $e->getMessage();
}

// Gọi layout chính để hiển thị mọi thứ ra màn hình
include 'Templates/layout.html.php';
