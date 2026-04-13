<?php
session_start();
include 'Includes/DatabaseConnection.php';
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    $sql = "SELECT * FROM users WHERE role = 'reviewer'";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll();

##################delete user

    if (isset($_POST['btn_delete_id'])){
        $sql = "DELETE FROM users WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->BindValue(':id', $_POST['user_id']);
        $stmt->execute();
        header('Location: ADMIN_manage_users.php');
        exit();

        }
    ob_start();
    include 'Templates/ADMIN_manage_users.html.php';
    $output = ob_get_clean();
    include 'Templates/layout.html.php';

} else{
    echo 'You are not an admin';
}