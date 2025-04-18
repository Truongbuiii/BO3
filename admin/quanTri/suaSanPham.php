<?php
require('./db/connect.php');

// Kiểm tra nếu request là POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $maSanPham = $_POST['MaSanPham'];  // Mã sản phẩm để tìm sản phẩm cần cập nhật
    $tenSanPham = $_POST['TenSanPham'];
    $maLoai = $_POST['MaLoai'];  // Mã loại kem
    $huongVi = $_POST['HuongVi'];
    $tinhTrang = $_POST['TinhTrang'];
    $donGia = $_POST['DonGia'];
    $hinhAnh = $_FILES['HinhAnh']['name'];  // Lấy tên ảnh mới (nếu có)

    // Kiểm tra nếu MaSanPham không hợp lệ
    if (empty($maSanPham)) {
        echo "ID sản phẩm không hợp lệ!";
        exit();
    }

    // Kiểm tra xem sản phẩm có tồn tại không
    $checkQuery = "SELECT MaSanPham FROM SanPham WHERE MaSanPham = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("s", $maSanPham);
    $stmtCheck->execute();
    $stmtCheck->store_result();
    
    // Nếu không tìm thấy sản phẩm, dừng lại
    if ($stmtCheck->num_rows == 0) {
        echo "Sản phẩm không tồn tại!";
        exit();
    }

    // Nếu có ảnh mới, upload ảnh
    if ($hinhAnh) {
        // Xử lý upload hình ảnh
        $targetDir = "images/";
        $targetFile = $targetDir . basename($hinhAnh);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra nếu hình ảnh là ảnh hợp lệ
        $checkImage = getimagesize($_FILES['HinhAnh']['tmp_name']);
        if ($checkImage === false) {
            echo "Tệp không phải là hình ảnh!";
            exit();
        }

        // Di chuyển hình ảnh vào thư mục
        if (!move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $targetFile)) {
            echo "Lỗi khi upload hình ảnh!";
            exit();
        }
    } else {
        // Nếu không có ảnh mới, giữ nguyên ảnh cũ
        $hinhAnh = $_POST['HinhAnh_cu'];  // Lấy hình ảnh cũ từ form
    }

    // Câu lệnh cập nhật sản phẩm
    $updateQuery = "UPDATE SanPham SET 
                        TenSanPham = ?, 
                        MaLoai = ?, 
                        HuongVi = ?, 
                        TinhTrang = ?, 
                        DonGia = ?, 
                        HinhAnh = ? 
                    WHERE MaSanPham = ?";

    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($updateQuery);
    if ($stmt === false) {
        echo "Lỗi khi chuẩn bị câu lệnh: " . $conn->error;
        exit();
    }

    // Gắn tham số cho câu lệnh
    $stmt->bind_param("sssssss", $tenSanPham, $maLoai, $huongVi, $tinhTrang, $donGia, $hinhAnh, $maSanPham);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Nếu thành công, hiển thị thông báo và quay lại trang danh sách sản phẩm
        echo "<script>
                alert('Cập nhật sản phẩm thành công!');
                window.location.href = 'danhSachSanPham.php';  // Thay đổi URL tới trang danh sách sản phẩm của bạn
              </script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    // Đóng statement
    $stmt->close();
    $stmtCheck->close();
}
?>
