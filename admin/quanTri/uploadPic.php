<?php
require('../db/conn.php');

if (isset($_POST['upload'])) {
    $TenSanPham = $_POST['TenSanPham'];
    $LoaiMay = $_POST['LoaiMay'];
    $TinhTrang = $_POST['TinhTrang'];
    $Gia = $_POST['Gia'];
    $DanhMuc = $_POST['DanhMuc'];
    $DuongKinh = $_POST['DuongKinh'] ?: null; // Nếu trống thì lưu null

    // Xử lý upload ảnh
    $target_dir = "images/"; // Thư mục lưu ảnh
    $image_name = basename($_FILES["HinhAnh"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $target_file)) {
        // Nếu upload thành công, lưu vào CSDL
        $sql = "INSERT INTO sanpham (TenSanPham, LoaiMay, TinhTrang, Gia, HinhAnh, DanhMuc, DuongKinh) 
                VALUES ('$TenSanPham', '$LoaiMay', '$TinhTrang', $Gia, '$target_file', '$DanhMuc', " . ($DuongKinh ? $DuongKinh : "NULL") . ")";
        
        if (mysqli_query($conn, $sql)) {
            echo "Thêm sản phẩm thành công!";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    } else {
        echo "Lỗi khi tải ảnh!";
    }
}
?>
