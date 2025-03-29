<?php
require('./db/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra dữ liệu nhận được
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit; // Debug dữ liệu gửi đi

    $id = $_POST['MaSanPham'] ?? null;
    $tenSanPham = $_POST['TenSanPham'] ?? null;
    $gia = $_POST['DonGia'] ?? null;
    $loaiKem = $_POST['MaLoai'] ?? null;
    $huongVi = $_POST['HuongVi'] ?? null;
    $tinhTrang = $_POST['TinhTrang'] ?? null;

    if ($id && $tenSanPham && $gia !== null && $loaiKem && $huongVi && $tinhTrang !== null) {
        $sql = "UPDATE SanPham 
                SET tenSanPham = ?, donGia = ?, maLoaiSanPham = ?, huongVi = ?, tinhTrang = ? 
                WHERE maSanPham = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdissi", $tenSanPham, $gia, $loaiKem, $huongVi, $tinhTrang, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật thành công!'); window.location.href='danhsachsanpham.php';</script>";
        } else {
            echo "<script>alert('Lỗi cập nhật!');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
    }
}
?>
