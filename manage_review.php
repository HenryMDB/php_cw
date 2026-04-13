<?php
session_start();
include 'Includes/DatabaseConnection.php';

if (isset($_SESSION['user_id'])) {
    $sql = 'SELECT review.*,
                    film.name AS film_name 
    FROM review
    INNER JOIN film ON review.film_id = film.id
    WHERE review.reviewer_id= :reviewer_id ORDER BY review.created_at DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->BindValue(':reviewer_id', $_SESSION['user_id']);
    $stmt->execute();
    $user_reviews = $stmt->fetchAll();

// ############delete
    if (isset($_POST['btn_delete_review'])) {
        $review_id = $_POST['review_id_to_delete'];

        $sql = 'DELETE FROM review WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->BindValue(':id', $review_id);
        $stmt->execute();

        header('Location: manage_review.php');
        exit();
    }

    ob_start();
    include 'Templates/manage_review.html.php';
    $output = ob_get_clean();
    include 'Templates/layout.html.php';
        

} else {
    echo 'You are not logged in';
}