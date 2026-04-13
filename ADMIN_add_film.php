<?php
session_start();
include 'Includes/DatabaseConnection.php';


if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    
    $sql_categories = "SELECT * FROM category ORDER BY category_name ASC";
    $stmt_categories = $pdo->query($sql_categories);
    $categories = $stmt_categories->fetchAll();


    if (isset($_POST['btn_add_film'])) {
        if (!isset($_POST['categories_picked']) || empty($_POST['categories_picked'])) {

        echo "<script>
                alert('⚠️ You must select at least 1 category!');
                history.back();
              </script>";
        exit();
    }

        $name = $_POST['name'];
        $type = $_POST['type'];
        $director = $_POST['director'];
        $trailer_url = $_POST['trailer_url'];
        $description = $_POST['description'];
        $selected_categories = $_POST['categories_picked'];

        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
            $poster_name = uniqid('poster_') . '.' . $extension;

            $destination = 'Images/Poster/' . $poster_name;
            move_uploaded_file($_FILES['poster']['tmp_name'], $destination);
        }

        // Lưu vào bảng film
        $sql_film = "INSERT INTO film SET 
                name = :name,
                type = :type,
                director = :director,
                trailer_url = :trailer_url,
                description = :description,
                poster = :poster";
        $stmt_film = $pdo->prepare($sql_film);
        $stmt_film->bindValue(':name', $name);
        $stmt_film->bindValue(':type', $type);
        $stmt_film->bindValue(':director', $director);
        $stmt_film->bindValue(':trailer_url', $trailer_url);
        $stmt_film->bindValue(':description', $description);
        $stmt_film->bindValue(':poster', $poster_name);
        $stmt_film->execute();

       
        $new_film_id = $pdo->lastInsertId();

        // Lưu vào bảng trung gian

        $sql_fc = "INSERT INTO film_category SET
                    film_id=:film_id,
                    category_id=:category_id";
        $stmt_fc = $pdo->prepare($sql_fc);

        foreach ($selected_categories as $cat_id) {
            $stmt_fc->bindValue(':film_id', $new_film_id);
            $stmt_fc->bindValue(':category_id', $cat_id);
            $stmt_fc->execute();
        }

        header('Location: index.php');
        exit();
    }

    ob_start();
    include 'Templates/ADMIN_add_film.html.php';
    $output = ob_get_clean();
    include 'Templates/layout.html.php';
} else {
    echo 'You do not have access permission';
}

