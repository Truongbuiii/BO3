<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy tên trang hiện tại
$currentPage = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['username']) && $currentPage !== 'login.php' && $currentPage !== 'index.php') {
    header("Location: index.php");
    exit();
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

