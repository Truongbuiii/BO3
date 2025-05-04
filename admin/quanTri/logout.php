<?php
// Bắt đầu session
session_start();

// Xóa toàn bộ biến session
$_SESSION = [];

// Nếu dùng cookie session, xóa luôn cookie đó
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

// Xóa cookie adminid
setcookie("adminid", "", time() - 3600, "/", "", isset($_SERVER['HTTPS']), true);

// Hủy session trên server
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit();
?>
