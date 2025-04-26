<?php
// Kết nối đến cơ sở dữ liệu
require("./db/connect.php");

// Kiểm tra nếu có tham số 'TenNguoiDung' trong URL
if (isset($_GET['TenNguoiDung'])) {
    $tenNguoiDung = $_GET['TenNguoiDung'];

    // Truy vấn để xóa người dùng khỏi bảng NguoiDung
    $sql = "DELETE FROM NguoiDung WHERE TenNguoiDung = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $tenNguoiDung);

    // Thực thi câu lệnh xóa
    if (mysqli_stmt_execute($stmt)) {
        // Nếu xóa thành công, chuyển hướng về trang danh sách người dùng và thông báo thành công
        header("Location: danhSachNguoiDung.php?success=1");
    } else {
        // Nếu có lỗi, chuyển hướng về trang danh sách người dùng và thông báo lỗi
        header("Location: danhSachNguoiDung.php?error=1");
    }

    // Đóng kết nối
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Nếu không có tham số 'TenNguoiDung', chuyển hướng về trang danh sách người dùng
    header("Location: danhSachNguoiDung.php");
}
?>
