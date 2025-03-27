<?php
require('./db/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $tenSanPham = $_POST['tenSanPham'];
    $gia = $_POST['gia'];
    $loaiKem = $_POST['loai'];
    $huongVi = $_POST['huongvi'];
    $tinhTrang = $_POST['tinhtrang'];

    $sql = "UPDATE SanPham SET tenSanPham = ?, gia = ?, LoaiKem = ?, huongVi = ?, tinhTrang = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdissi", $tenSanPham, $gia, $loaiKem, $huongVi, $tinhTrang, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location='danhsachsanpham.php';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật!');</script>";
    }
}
?>
