<?php
session_start();include 'Includes/DatabaseConnection.php';

$error = '';
$success = '';

// KHI NGƯỜI DÙNG BẤM NÚT "HỦY" HOẶC MUỐN NHẬP LẠI EMAIL
if (isset($_POST['btn_cancel'])) {
    unset($_SESSION['reset_email']);
    unset($_SESSION['otp']);
    unset($_SESSION['otp_time']);
    unset($_SESSION['otp_verified']);
    header('Location: forgot_password.php');
    exit();
}

// BƯỚC 1: XỬ LÝ GỬI EMAIL CHỨA MÃ OTP
if (isset($_POST['btn_send_otp'])) {
    $email = $_POST['email'];
    $sql = "SELECT id,username FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_time'] = time(); //Unix Timestamp

        // ---- GỬI MAIL ----
        $receiver = $email;
        $subject = "Password Recovery Verification Code";
        $body = "Hello,\n\nThe verification code (OTP) for account" . " ". $user['username'] . " is: " . $otp . "\n\nThis code will expire in 5 minutes.";
        $sender = "From: datnqgch230599@gmail.com"; 
        
        if (mail($receiver, $subject, $body, $sender)) {
            $success = "OTP code has been sent to your email!";
        } else {
            $error = "System error: Cannot send email at this time!";
        }
    } else {
        $error = "This Email address is not registered!";
    }
}

// BƯỚC 2: XỬ LÝ XÁC THỰC MÃ OTP
if (isset($_POST['btn_verify_otp'])) {
    $user_otp = $_POST['otp_input'];
    if (time() - $_SESSION['otp_time'] > 300) {
        $error = "OTP code has expired! Please Cancel and get a new one.";
        unset($_SESSION['otp']);
    } elseif ($user_otp == $_SESSION['otp']) {
        $_SESSION['otp_verified'] = true;
        $success = "Authentication successful. Please enter your new password!";
    } else {
        $error = "Incorrect OTP code!";
    }
}

// BƯỚC 3: XỬ LÝ LƯU MẬT KHẨU MỚI
if (isset($_POST['btn_reset'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Password confirmation does not match!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':password', $hashed_password);
        $stmt->bindValue(':email', $_SESSION['reset_email']);
        $stmt->execute();

        // clear Session
        unset($_SESSION['reset_email'], $_SESSION['otp'], $_SESSION['otp_time'], $_SESSION['otp_verified']);

        $_SESSION['success_msg'] = "Password changed successfully! Please log in.";
        header('Location: login.php');
        exit();
    }
}
// KIỂM TRA XEM ĐANG Ở BƯỚC MẤY
$step = 1; // Mặc định là Form nhập Email
if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
    $step = 3; // Đã xác thực OTP -> Form đổi mật khẩu
} elseif (isset($_SESSION['otp'])) {
    $step = 2; // Đã gửi OTP -> Form nhập mã 6 số
}

// Gọi giao diện
ob_start();
include 'Templates/forgot_password.html.php';
$output = ob_get_clean();
include 'Templates/layout.html.php';
?>