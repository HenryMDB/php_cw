<?php
session_start();
include 'Includes/DatabaseConnection.php';
$error = '';
if (isset($_POST['btn_register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $sql = 'SELECT COUNT(*) FROM users WHERE username=:username';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $count_user = $stmt->fetchColumn();

    $sql = 'SELECT COUNT(*) FROM users WHERE email=:email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $count_email = $stmt->fetchColumn();


    if ($count_user > 0 || $count_email > 0) {
        $error = 'Username or Email already exists';
    } elseif ($password_check != $password) {
        $error = 'Passwords do not match';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users SET
                username = :username,
                password = :password,
                firstname = :firstname,
                lastname = :lastname,
                email = :email';


        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $hashed_password);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $_SESSION['success_msg'] = 'Registration successful. Please log in with your new account!';
        header('Location: login.php');
        exit();
    };
};


// Gọi giao diện
ob_start();
include 'Templates/register.html.php';
$output = ob_get_clean();
include 'Templates/layout.html.php';
