<?php
session_start();
include 'Includes/DatabaseConnection.php';

$error = '';
// Nếu người dùng bấm nút Submit form
if (isset($_POST['btn_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM users WHERE username = :username';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Kiểm tra mật khẩu
    // if ($user && password_verify($password, $user['password'])) {
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // để hiện menu Admin

        // Chuyển hướng về trang chủ
        header('Location: index.php');
        exit();

    } else {
        $error = 'Incorrect username or password!';
    }
}

ob_start();
include 'Templates/login.html.php';
$output = ob_get_clean();
include 'Templates/layout.html.php';
