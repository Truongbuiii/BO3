<?php
require('./db/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy MaSanPham từ form


// Giả sử id là khóa chính số nguyên trong bảng SanPham
$maSanPham = $_POST['id']; // giả sử POST gửi lên là 'SP001'
    echo "<script>console.log('Mã sản phẩm nhận được từ form: " . $maSanPham . "');</script>";

$sql_getMaSP = "SELECT MaSanPham FROM SanPham WHERE MaSanPham = ?";
$stmt = $conn->prepare($sql_getMaSP);
$stmt->bind_param("s", $maSanPham); // chuỗi ký tự SP001

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$maSanPham = $row['MaSanPham'];

    // Kiểm tra xem sản phẩm có tồn tại trong hóa đơn không
    $sql_check = "SELECT COUNT(DISTINCT MaHoaDon) AS count FROM ChiTietHoaDon WHERE MaSanPham = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $maSanPham); // s = string
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    // Debug: In số lượng sản phẩm đã bán
    echo "<script>alert('Số lượng sản phẩm đã được bán: " . $row_check['count'] . "');</script>";

    // Kiểm tra xem sản phẩm đã được bán chưa
    if ($row_check['count'] > 0) {
        // Nếu có đơn hàng chứa sản phẩm này, yêu cầu xác nhận trước khi ẩn sản phẩm
        echo "<script>
                var confirmHide = confirm('Sản phẩm này đã được bán. Bạn có chắc chắn muốn ẩn sản phẩm không?');
                if (confirmHide) {
                    // Thực hiện ẩn sản phẩm nếu người dùng xác nhận
                    window.location = 'danhsachsanpham.php?id=" . $maSanPham . "&action=hide';
                } else {
                    window.location = 'danhsachsanpham.php';
                }
              </script>";
    } else {
        // Xóa sản phẩm khỏi bảng SanPham (Nếu sản phẩm chưa được bán)
        $sql_delete = "DELETE FROM SanPham WHERE MaSanPham = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("s", $maSanPham);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Xóa sản phẩm thành công!'); window.location='danhsachsanpham.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa sản phẩm!'); window.location='danhsachsanpham.php';</script>";
        }
    }
}

// Nếu nhận được yêu cầu ẩn sản phẩm (từ hành động ẩn)
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'hide') {
    $maSanPham = $_GET['id'];

    // Kiểm tra lại MaSanPham
if (!empty($maSanPham)) {
        // Cập nhật trạng thái sản phẩm thành ẩn (tinhTrang = 0)
        $sql_update = "UPDATE SanPham SET tinhTrang = 0 WHERE MaSanPham = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("s", $maSanPham);
        if ($stmt_update->execute()) {
            echo "<script>alert('Sản phẩm đã được ẩn thành công!'); window.location='danhsachsanpham.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi ẩn sản phẩm!'); window.location='danhsachsanpham.php';</script>";
        }
    } else {
        // Nếu không có mã sản phẩm hợp lệ, chuyển hướng về danh sách sản phẩm
        echo "<script>alert('Không có mã sản phẩm hợp lệ!'); window.location='danhsachsanpham.php';</script>";
    }
}
?>
