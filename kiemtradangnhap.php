<?php

if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: index.php");
    exit();
}
?>
