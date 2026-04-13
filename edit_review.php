<?php
session_start();include 'Includes/DatabaseConnection.php';

// BẢO MẬT: Bọc toàn bộ code trong khối kiểm tra Session
if (isset($_SESSION['user_id'])) {
    
    $reviewer_id = $_SESSION['user_id'];
//LẤY DỮ LIỆU CŨ TỪ TRANG MANAGE_REVIEW ĐỂ HIỂN THỊ
    // Dùng GET vì ID được truyền qua URL (?id=...)
    if (isset($_GET['id'])) {
        $review_id = $_GET['id'];
        
        $sql_select = "SELECT review.*, film.name AS film_name 
                       FROM review 
                       INNER JOIN film ON review.film_id = film.id 
                       WHERE review.id = :id AND review.reviewer_id = :reviewer_id";// tránh lấy id của người khác
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->bindValue(':id', $review_id);
        $stmt_select->bindValue(':reviewer_id', $reviewer_id);
        $stmt_select->execute();

        $review = $stmt_select->fetch();

        // 
        if (!$review) {
            header('Location: manage_review.php');
            exit();
        }
    } else {
        // Nếu trên URL không có ID -> đuổi về trang quản lý
        header('Location: manage_review.php');
        exit();
    }

// =======================================================
//XỬ LÝ LƯU DỮ LIỆU (KHI NGƯỜI DÙNG BẤM NÚT SUBMIT FORM)
    if (isset($_POST['btn_update_review'])) {
        $review_id = $_POST['review_id'];
        $rating = $_POST['rating'];
        $detail = $_POST['detail'];
        $screenshot = $_POST['screenshot'];

        // // Xử lý ảnh: Mặc định giữ ảnh cũ
        // $screenshot_name = $old_screenshot;
        
        // Kiểm tra xem người dùng có chọn tải ảnh mới lên không
        if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
            $extension = pathinfo($_FILES['screenshot']['name'], PATHINFO_EXTENSION);
            $screenshot = uniqid('review_') . '.' . $extension;
            $destination = 'Images/Screenshot/' . $screenshot;
            move_uploaded_file($_FILES['screenshot']['tmp_name'], $destination);
        }

        // Cập nhật Database
        $sql_update = "UPDATE review SET 
                       rating = :rating, detail = :detail, screenshot = :screenshot 
                       WHERE id = :id AND reviewer_id = :reviewer_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindValue(':rating', $rating);
        $stmt_update->bindValue(':detail', $detail);
        $stmt_update->bindValue(':screenshot', $screenshot);
        $stmt_update->bindValue(':id', $review_id);
        $stmt_update->bindValue(':reviewer_id', $reviewer_id);
        $stmt_update->execute();


        header('Location: manage_review.php');
        exit();
    }



    // Gọi giao diện HTML
    ob_start();
    include 'Templates/edit_review.html.php';
    $output = ob_get_clean();
    include 'Templates/layout.html.php';

} else {
    // Nếu chưa đăng nhập thì "đá" văng về trang Đăng nhập
    header('Location: login.php');
    exit();
}
?>