<?php
session_start();include 'Includes/DatabaseConnection.php';

// BẢO MẬT TUYỆT ĐỐI: Kiểm tra xem người dùng có đăng nhập và có phải Admin không
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {

    // Kiểm tra xem trên URL có truyền ID phim không
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }
    $film_id = $_GET['id'];

        // 2: LẤY DỮ LIỆU CŨ ĐỂ ĐỔ VÀO FORM
    // ====================================================
    $sql_film = "SELECT * FROM film WHERE id = :id";
    $stmt = $pdo->prepare($sql_film);
    $stmt->bindValue(':id', $film_id);
    $stmt->execute();
    $film = $stmt->fetch();

    if (!$film) { 
        header('Location: index.php');
        exit();
    }

    $sql_categories = "SELECT * FROM category";
    $categories = $pdo->query($sql_categories)->fetchAll();

    $sql_current_cats = "SELECT category_id FROM film_category WHERE film_id = :id";
    $stmt = $pdo->prepare($sql_current_cats);
    $stmt->bindValue(':id', $film_id);
    $stmt->execute();
    $current_category_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    
    
    
    // 1: XỬ LÝ DỮ LIỆU KHI ADMIN BẤM "LƯU THAY ĐỔI"

    if (isset($_POST['btn_edit_film'])) {
        if (!isset($_POST['categories']) || empty($_POST['categories'])){
        echo "<script>
                alert('⚠️ You must select at least 1 category!');
                history.back();
              </script>";
        exit();
        }

        $name = $_POST['name'];
        $type = $_POST['type'];
        $director = $_POST['director'];
        $trailer_url = $_POST['trailer_url'] ?? '';
        $description = $_POST['description'] ?? '';
        $selected_categories = $_POST['categories'];

        $poster_query = ""; 
        $has_new_poster = false;
        
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
            $poster_name = 'poster_' . uniqid() . '.' . pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['poster']['tmp_name'], 'Images/Poster/' . $poster_name);
            $poster_query = ", poster = :poster"; 
            $has_new_poster = true;
        }

        // Cập nhật bảng `film`
        $sql_update_film = "UPDATE film SET name = :name, 
                            type = :type, 
                            director = :director,
                            trailer_url = :trailer_url,
                            description = :description 
                            $poster_query 
                            WHERE id = :id";
        $stmt = $pdo->prepare($sql_update_film);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':director', $director);
        $stmt->bindValue(':trailer_url', $trailer_url);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':id', $film_id);
        if ($has_new_poster == true) {
            $stmt->bindValue(':poster', $poster_name);
        }
        $stmt->execute();

        // Cập nhật bảng `film_category`
        $sql_delete_cat = "DELETE FROM film_category WHERE film_id = :film_id";
        $stmt = $pdo->prepare($sql_delete_cat);
        $stmt->bindValue(':film_id', $film_id);
        $stmt->execute();

        $sql_insert_cat = "INSERT INTO film_category (film_id, category_id) 
                            VALUES (:film_id, :category_id)";
        $stmt = $pdo->prepare($sql_insert_cat);
        foreach ($selected_categories as $cat_id) {
            $stmt->bindValue(':film_id', $film_id);
            $stmt->bindValue(':category_id', $cat_id);
            $stmt->execute();

        }

        header('Location: index.php'); 
        exit();
    }
    
    ob_start();
    include 'Templates/ADMIN_edit_film.html.php';
    $output = ob_get_clean();
    include 'Templates/layout.html.php';

} else {
    header('Location: index.php');
    exit();
}
?>