<?php
require('./db/connect.php');
require('./ansanpham.php'); // Bao gồm file xử lý ẩn sản phẩm

// Kiểm tra nếu request là POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $maSanPham = $_POST['MaSanPham'];
    $tenSanPham = $_POST['TenSanPham'];
    $maLoai = $_POST['MaLoai'];
    $huongVi = $_POST['HuongVi'];
    $tinhTrang = $_POST['TinhTrang'];
    $donGia = $_POST['DonGia'];
    $hinhAnh = null;

    // Xử lý upload hình ảnh
    if (!empty($_FILES['HinhAnh']['name']) && is_uploaded_file($_FILES['HinhAnh']['tmp_name'])) {
        $hinhAnh = $_FILES['HinhAnh']['name'];
        $targetDir = "../../images/";
        $targetFile = $targetDir . basename($hinhAnh);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Đảm bảo thư mục tồn tại
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Kiểm tra xem có phải hình ảnh không
        $checkImage = getimagesize($_FILES['HinhAnh']['tmp_name']);
        if ($checkImage === false) {
            echo "Tệp không phải là hình ảnh!";
            exit();
        }

        // Di chuyển file hình ảnh đến thư mục lưu trữ
        if (!move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $targetFile)) {
            echo "Lỗi khi upload hình ảnh!";
            exit();
        }

    } else {
        $hinhAnh = $_POST['HinhAnh_cu'];
    }

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


     // Số sản phẩm mỗi trang (nên dùng đúng số ở danh sách)
$limit = 10;

// Lấy vị trí của sản phẩm theo thứ tự MaSanPham tăng dần
$positionQuery = "SELECT COUNT(*) AS position FROM SanPham WHERE MaSanPham <= ? ORDER BY MaSanPham ASC";
$stmtPos = $conn->prepare("SELECT COUNT(*) AS position FROM (SELECT MaSanPham FROM SanPham ORDER BY MaSanPham ASC) AS Ordered WHERE MaSanPham <= ?");
$stmtPos->bind_param("s", $maSanPham);
$stmtPos->execute();
$resultPos = $stmtPos->get_result();
$rowPos = $resultPos->fetch_assoc();

$page = ceil($rowPos['position'] / $limit);
$stmtPos->close();


    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Kiểm tra nếu sản phẩm đã bị khóa (TinhTrang == 'khóa')
        if ($tinhTrang == 'khóa') {
            // Cập nhật lại trạng thái sản phẩm (ẩn sản phẩm khỏi danh sách)
            echo "<script>
                    alert('Sản phẩm đã bị khóa và sẽ không hiển thị trong danh sách sản phẩm!');
                    window.location.href = 'danhSachSanPham.php';  
                  </script>";
        } else {
           echo "<script>
        alert('Cập nhật sản phẩm thành công!');
        window.location.href = 'danhsachsanpham.php?page={$page}';  
      </script>";

        }
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    // Đóng statement
    $stmt->close();
    $stmtCheck->close();
}
?>
