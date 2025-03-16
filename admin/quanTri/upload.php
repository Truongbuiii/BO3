<?php
require("db/connect.php"); // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenSanPham = $_POST["tenSanPham"];
    
    // Thư mục lưu ảnh
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["hinhAnh"]["name"]);
    
    // Lưu ảnh vào thư mục trên server
    if (move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $target_file)) {
        $hinhAnh = basename($_FILES["hinhAnh"]["name"]); // Lưu tên file vào database

        // Chèn sản phẩm vào database
        $sql = "INSERT INTO SanPham (tenSanPham, hinhAnh) VALUES ('$tenSanPham', '$hinhAnh')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Thêm sản phẩm thành công!";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    } else {
        echo "Lỗi khi tải ảnh lên.";
    }
}
?>
