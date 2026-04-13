<?php
session_start();
include 'Includes/DatabaseConnection.php';

$searchName = $_GET['searchName'] ?? '';
$searchType = $_GET['searchType'] ?? '';
$searchCategory = $_GET['searchCategory'] ?? '';

// Fetch categories for the dropdown
$categoriesStmt = $pdo->query("SELECT id, category_name FROM category ORDER BY category_name ASC");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT 
        film.id, 
        film.name, 
        film.type, 
        GROUP_CONCAT(category.category_name SEPARATOR ', ') AS category_name, 
        film.poster, 
        film.director 
    FROM film 
    INNER JOIN film_category ON film.id = film_category.film_id 
    INNER JOIN category ON film_category.category_id = category.id
    WHERE 1=1";

$params = [];

if (!empty($searchName)) {
    $sql .= " AND film.name LIKE :searchName";
    $params[':searchName'] = '%' . $searchName . '%';
}

if (!empty($searchType)) {
    $sql .= " AND film.type = :searchType";
    $params[':searchType'] = $searchType;
}

if (!empty($searchCategory)) {
    $sql .= " AND film.id IN (SELECT film_id FROM film_category WHERE category_id = :searchCategory)";
    $params[':searchCategory'] = $searchCategory;
}

$sql .= " GROUP BY film.id";

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) {
    if (is_int($val)) {
        $stmt->bindValue($key, $val, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $val);
    }
}
$stmt->execute();
$films = $stmt->fetchAll();

ob_start();
include 'Templates/films.html.php';
$output = ob_get_clean();

include 'Templates/layout.html.php';
