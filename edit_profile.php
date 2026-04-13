<?php
session_start();include 'Includes/DatabaseConnection.php';

// BẢO MẬT: Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    
    $user_id = $_SESSION['user_id'];
    $error = '';
    $success = '';
    // lấy thông tin cũ
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch();

    // bấm update
    if (isset($_POST['btn_update'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        //Check mail trừ mình

        $sql_check = 'SELECT COUNT(*) FROM users WHERE email=:email AND id!=:id';
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->BindValue(':email', $email);
        $stmt_check->BindValue(':id', $user_id);
        $stmt_check->execute();
        $email_exists = $stmt_check->fetchColumn();


        if ($email_exists > 0){
            $error = '⚠️ This email is already used by another account!';
        // Nếu người dùng CÓ nhập mật khẩu mới
        } else {  if (!empty($new_password)) {
                    if ($new_password !== $confirm_password) {
                        $error = 'Password confirmation does not match!';
                    } else {
                        // Băm mật khẩu mới
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password WHERE id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindValue(':password', $hashed_password);
                        }
                    } else {
                        // Nếu BỎ TRỐNG mật khẩu mới -> Chỉ cập nhật Tên và Email
                        $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
                        $stmt = $pdo->prepare($sql);
                    }
        }

        // Nếu không có lỗi gì thì chạy lệnh UPDATE
        if (empty($error)) {
            $stmt->bindValue(':firstname', $firstname);
            $stmt->bindValue(':lastname', $lastname);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':id', $user_id);
            $stmt->execute();
            
            $success = '✅ Profile updated successfully!';
        }
    }

    // Gọi giao diện
    ob_start();
    include 'Templates/edit_profile.html.php';
    $output = ob_get_clean();
    include 'Templates/layout.html.php';

} else {
    // Nếu chưa đăng nhập thì "đá" văng về trang Đăng nhập
    header('Location: login.php');
    exit();
}
?>