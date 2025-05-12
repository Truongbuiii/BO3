<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy tên file của trang hiện tại
$currentPage = basename($_SERVER['PHP_SELF']);

// Các trang không yêu cầu đăng nhập
$allowedPages = ['index.php',  'kemLy.php','kemOcQue.php','kemQue.php',  'chitietsanpham.php']; // Thêm tên file bạn muốn cho truy cập tự do

// Nếu chưa đăng nhập và trang hiện tại không nằm trong danh sách cho phép
if (!isset($_SESSION['username']) && !in_array($currentPage, $allowedPages)) {
    header("Location: index.php");
    exit();
}
?>
