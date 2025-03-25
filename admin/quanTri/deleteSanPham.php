<?php
require('./db/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM SanPham WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Xóa thành công!'); window.location='danhsachsanpham.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa!');</script>";
    }
}
?>
