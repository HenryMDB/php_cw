<?php
session_start();include 'Includes/DatabaseConnection.php';

// Bọc toàn bộ code trong khối kiểm tra Session
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['btn_add_review'])) {

        $film_id = $_POST['film_id'];
        $rating = $_POST['rating'];
        $detail = $_POST['detail'];
        $reviewer_id = $_SESSION['user_id'];


        // UPLOAD ẢNH
        $screenshot_name = ''; // Mặc định là rỗng
        if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK) {
            // Lấy đuôi file
            $extension = pathinfo($_FILES['screenshot']['name'], PATHINFO_EXTENSION);
            // Đổi tên ảnh thành một mã duy nhất
            $screenshot_name = uniqid('review_') . '.' . $extension;

            // Di chuyển ảnh từ tm tạm của XAMPP vào source code
            $destination = 'Images/Screenshot/' . $screenshot_name;
            move_uploaded_file($_FILES['screenshot']['tmp_name'], $destination);
        }

        // 4. LƯU VÀO DATABASE VÀ CHUYỂN HƯỚN
        try {
            $sql = "INSERT INTO review SET
                    film_id = :film_id,
                    reviewer_id = :reviewer_id,
                    rating = :rating,
                    detail = :detail,
                    screenshot = :screenshot,
                    created_at = NOW()";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':film_id', $film_id);
            $stmt->bindValue(':reviewer_id', $reviewer_id);
            $stmt->bindValue(':rating', $rating);
            $stmt->bindValue(':detail', $detail);
            $stmt->bindValue(':screenshot', $screenshot_name);
            $stmt->execute();

            header('Location: reviews.php?id=' . $film_id);
            exit();

        } catch (PDOException $e) {
            echo "Error saving review: " . $e->getMessage();
        }
    }

} else {
    // Đuổi về home
    header('Location: index.php');
    exit();
}
?>