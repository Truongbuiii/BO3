<?php
require('./db/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['MaSanPham'] ?? null;
    $tenSanPham = $_POST['TenSanPham'] ?? null;
    $gia = $_POST['DonGia'] ?? null;
    $loaiKem = $_POST['MaLoai'] ?? null; // Kiểm tra lại tên cột
    $huongVi = $_POST['HuongVi'] ?? null;
    $tinhTrang = $_POST['TinhTrang'] ?? null;

    if (!empty($id) && !empty($tenSanPham) && isset($gia) && !empty($loaiKem) && !empty($huongVi) && isset($tinhTrang)) {
        // Cập nhật đúng tên cột trong CSDL
        $sql = "UPDATE SanPham 
                SET tenSanPham = ?, donGia = ?, MaLoai = ?, huongVi = ?, tinhTrang = ? 
                WHERE MaSanPham = ?";
        
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
