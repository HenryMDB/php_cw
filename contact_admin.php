<?php
session_start();
include 'Includes/DatabaseConnection.php';
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['btn_send_email'])){
        $receiver = "datnqgch230599@gmail.com";
        $subject = "User:" . $_SESSION['username'] . " <Sent a message to admin>";
        $body = $_POST['message'];
        $sender = "From: datnqgch230599@gmail.com";

        if (mail($receiver, $subject, $body, $sender)) {
            echo "<script>alert('✅ Message sent to Admin successfully!');</script>";
        } else {
            echo "<script>alert('❌ Failed to send message. Please try again later.');</script>";
        }
    }
    ob_start();
    include 'Templates/contact_admin.html.php';
    $output = ob_get_clean();
    include 'Templates/layout.html.php';
} else {
    echo 'You are not logged in';
}
