<?php
session_start();

$host = "localhost";
$db = "tiemKem"; // tên CSDL thật sự của bạn
$user = "root"; // hoặc username MySQL bạn đang dùng
$pass = "";     // hoặc mật khẩu thật nếu bạn đã đặt

$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$username = $_POST['username'];
$password = $_POST['password'];

// Chuẩn bị truy vấn để tránh SQL Injection
$stmt = $conn->prepare("SELECT TenNguoiDung,MatKhau FROM NguoiDung WHERE TenNguoiDung= ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['MatKhau'];

    // So sánh mật khẩu nhập với mật khẩu đã hash trong CSDL
    if (password_verify($password, $hashedPassword)) {
        // Lưu thông tin đăng nhập vào session
        $_SESSION['adminid'] = $row['TenNguoiDung'];

        // Chuyển hướng sang trang quản trị
        header("Location: /admin/quantri/index.php");
        exit;
    } else {
        echo "Sai mật khẩu!";
    }
} else {
    echo "Tên người dùng không tồn tại!";
}

$stmt->close();
$conn->close();
?>
