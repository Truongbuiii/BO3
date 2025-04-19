<?php
require('./db/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy MaSanPham từ form
    $maSanPham = $_POST['id'];

    // Kiểm tra xem sản phẩm có tồn tại trong hóa đơn không
    $sql_check = "SELECT COUNT(*) AS count FROM ChiTietHoaDon WHERE MaSanPham = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $maSanPham);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    // Debug: In số lượng sản phẩm trong hóa đơn
    echo "<script>alert('Số lượng sản phẩm trong hóa đơn: " . $row_check['count'] . "');</script>";

    // Kiểm tra xem sản phẩm đã được bán chưa
    if ($row_check['count'] > 0) {
        // Nếu có đơn hàng chứa sản phẩm này, không cho phép xóa
        echo "<script>alert('Sản phẩm này đã được bán, không thể xóa!'); window.location='danhsachsanpham.php';</script>";
    } else {
        // Xóa sản phẩm khỏi bảng SanPham (Nếu sản phẩm chưa được bán)
        $sql_delete = "DELETE FROM SanPham WHERE MaSanPham = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $maSanPham);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Xóa sản phẩm thành công!'); window.location='danhsachsanpham.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa sản phẩm!'); window.location='danhsachsanpham.php';</script>";
        }
    }
}
?>
