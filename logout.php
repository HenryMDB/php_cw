<?php
session_start();
include 'Includes/DatabaseConnection.php';

// Xóa sạch toàn bộ dữ liệu trong Session
session_unset();

// Phá hủy luôn cái Session đó
session_destroy();

// Chuyển hướng về trang chủ
header('Location: index.php');
exit();
