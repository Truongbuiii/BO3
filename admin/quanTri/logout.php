<?php
session_start();

// Xóa toàn bộ biến session
$_SESSION = [];

// Xóa cookie session (nếu có dùng cookie session)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

// Xóa cookie tùy chỉnh (nếu có)
setcookie("adminid", "", time() - 3600, "/", "", isset($_SERVER['HTTPS']), true);

// Hủy session trên server
session_destroy();

// Ép đóng session
session_write_close(); // <-- rất quan trọng nếu có vấn đề lưu session

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit();
?>
