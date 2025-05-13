<?php
// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "b03db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu có mã hóa đơn
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Lấy thông tin hóa đơn và người đặt hàng
   $orderSql = "
    SELECT hd.MaHoaDon, hd.TrangThai, hd.TongTien, nd.TenNguoiDung, nd.Email, nd.SoDienThoai
    FROM HoaDon hd
    JOIN NguoiDung nd ON hd.TenNguoiDung = nd.TenNguoiDung
    WHERE hd.MaHoaDon = ?
";

    $stmt = $conn->prepare($orderSql);
    if ($stmt === false) {
        die('Error in SQL query: ' . $conn->error);
    }
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $orderResult = $stmt->get_result();

    if ($orderResult->num_rows > 0) {
        $order = $orderResult->fetch_assoc();

        // Lấy chi tiết hóa đơn có JOIN sản phẩm
        $orderDetailsSql = "
            SELECT cthd.SoLuong, sp.TenSanPham, cthd.DonGia
            FROM ChiTietHoaDon cthd
            JOIN SanPham sp ON cthd.MaSanPham = sp.MaSanPham
            WHERE cthd.MaHoaDon = ?
        ";
        $stmt = $conn->prepare($orderDetailsSql);
        if ($stmt === false) {
            die('Error in SQL query: ' . $conn->error);
        }
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $orderDetailsResult = $stmt->get_result();
    } else {
        echo "Đơn hàng không tồn tại.";
        exit;
    }
} else {
    echo "Không có mã đơn hàng.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css"> <!-- Đường dẫn CSS -->
  <style>
   body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #f6f9fc, #e5f0ff);
    margin: 0;
    padding: 0;
}

.container {
    margin: 40px auto;
    max-width: 800px;
    background-color: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

h3 {
    color: #2b4eff;
    font-size: 30px;
    margin-bottom: 25px;
    text-align: center;
    font-weight: bold;  /* Làm đậm tiêu đề */
}

h4 {
    font-size: 20px;
    margin-top: 30px;
    margin-bottom: 10px;
    color: #444;
    border-left: 4px solid #2b4eff;
    padding-left: 10px;
    font-weight: bold;  /* Làm đậm tiêu đề phụ */
}

p {
    font-size: 16px;
    color: #444;
    margin: 5px 0 10px 0;
    font-weight: normal;  /* Giữ chữ bình thường */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table th {
    background-color: #d6e4ff;
    color: #2b4eff;
    padding: 12px;
    text-align: left;
    border-bottom: 2px solid #b0c4de;
    font-weight: bold;  /* Làm đậm chữ trong tiêu đề bảng */
}

table td {
    padding: 12px;
    font-size: 15px;
    color: #333;
    border-bottom: 1px solid #eee;
}

table tr:nth-child(even) {
    background-color: #f9faff;
}

table tr:hover {
    background-color: #eef3ff;
}

.btn {
    display: inline-block;
    background-color: #2b4eff;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 16px;
    margin-top: 30px;
    text-align: center;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #1f3edc;
}

.btn-secondary {
    background-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

strong {
    color: #2b4eff;
    font-weight: bold;  /* Làm đậm chữ in đậm */
}

</style>

</head>
<body>

<div class="container">
    <h3>Chi tiết đơn hàng #<?= htmlspecialchars($order['MaHoaDon']) ?></h3>
    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['TrangThai']) ?></p>

    <!-- Thông tin người đặt hàng -->
    <h4>Thông tin người đặt hàng:</h4>
    <p><strong>Tên:</strong> <?= htmlspecialchars($order['TenNguoiDung']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($order['Email']) ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['SoDienThoai']) ?></p>

    <h4>Chi tiết sản phẩm:</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            <?php
           $tongTienSanPham = 0;

while ($detail = $orderDetailsResult->fetch_assoc()) {
    $thanhTien = $detail['SoLuong'] * $detail['DonGia'];
    $tongTienSanPham += $thanhTien;

    echo "<tr>";
    echo "<td>" . htmlspecialchars($detail['TenSanPham']) . "</td>";
    echo "<td>" . htmlspecialchars($detail['SoLuong']) . "</td>";
    echo "<td>" . number_format($detail['DonGia'], 0, ',', '.') . " VND</td>";
    echo "</tr>";
}

            ?>
        </tbody>
         
    </table>
    <?php
    $phiShip = 30000;
    $tongThanhToan = $tongTienSanPham + $phiShip;
?>

<p><strong>Tổng tiền sản phẩm:</strong> <?= number_format($tongTienSanPham, 0, ',', '.') ?> VNĐ</p>
<p><strong>Phí vận chuyển:</strong> <?= number_format($phiShip, 0, ',', '.') ?> VNĐ</p>
<p><strong>Tổng thanh toán:</strong> <?= number_format($tongThanhToan, 0, ',', '.') ?> VNĐ</p>

    <a href="user.php" class="btn btn-secondary">Quay lại</a>
</div>

</body>
</html>
