<?php
// logout.php
session_start();  // Bắt đầu session để có thể thao tác với session

// Xóa tất cả các session
$_SESSION = [];  // Làm sạch dữ liệu trong session

// Nếu session cookie tồn tại, xoá cookie đó
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Hủy session
session_destroy();  // Hủy session hiện tại

// Xoá cookie lưu trữ adminid nếu có
if (isset($_COOKIE['adminid'])) {
    setcookie('adminid', '', time() - 3600, '/');  // Xóa cookie 'adminid' với thời gian đã qua
}

// Đảm bảo rằng người dùng không còn ở trạng thái đã đăng nhập khi vào lại index
// Xóa cookie "adminid" nếu có tồn tại, không chỉ trong logout mà ngay cả khi quay lại index
if (isset($_COOKIE['adminid'])) {
    setcookie('adminid', '', time() - 3600, '/'); // Xóa cookie adminid
}

// Chuyển hướng về trang login
header("Location: login.php");
exit;
?>
