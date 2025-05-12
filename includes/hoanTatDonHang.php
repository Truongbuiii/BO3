<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Mặc định của XAMPP
$password = ""; // Mặc định không có mật khẩu
$dbname = "b03db";

// Kết nối MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra nếu có mã hóa đơn từ query string
if (isset($_GET['maHoaDon']) && is_numeric($_GET['maHoaDon'])) {
    $maHoaDon = $_GET['maHoaDon'];
} else {
    echo "Mã hóa đơn không hợp lệ!";
    exit;
}

// Truy vấn thông tin hóa đơn từ bảng HoaDon
$sql = "SELECT * FROM HoaDon WHERE MaHoaDon = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maHoaDon);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu không tìm thấy mã hóa đơn
if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    echo "Không tìm thấy đơn hàng!";
    exit;
}

// Truy vấn chi tiết sản phẩm trong hóa đơn từ bảng ChiTietHoaDon
$sql_ct = "SELECT cthd.SoLuong, cthd.DonGia, sp.TenSanPham 
           FROM ChiTietHoaDon cthd 
           JOIN SanPham sp ON cthd.MaSanPham = sp.MaSanPham 
           WHERE cthd.MaHoaDon = ?";
$stmt_ct = $conn->prepare($sql_ct);
$stmt_ct->bind_param("i", $maHoaDon);
$stmt_ct->execute();
$result_ct = $stmt_ct->get_result();

$order_details = [];
while ($item = $result_ct->fetch_assoc()) {
    $order_details[] = $item;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Hoàn tất đơn hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffe6ec, #e3f6f5);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .thankyou-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            text-align: center;
            max-width: 550px;
            width: 100%;
        }
        .thankyou-container i {
            font-size: 60px;
            color: #90e0ef;
            margin-bottom: 20px;
        }
        .thankyou-container h2 {
            color: #0081a7;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .thankyou-container p {
            color: #555;
            font-size: 16px;
        }
        .btn-back-home {
            margin-top: 25px;
            padding: 10px 25px;
            background-color: #00b4d8;
            color: #fff;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .btn-back-home:hover {
            background-color: #0077b6;
        }
        .order-summary {
            text-align: left;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="thankyou-container">
        <i class="fa-solid fa-ice-cream"></i>
        <h2>Đơn hàng đã được đặt thành công!</h2>
        <p>Cảm ơn bạn đã lựa chọn cửa hàng kem của chúng tôi. Chúng tôi sẽ xác nhận đơn và giao hàng sớm nhất có thể.</p>

        <div class="order-summary">
            <p><strong>Mã hóa đơn:</strong> <?php echo $order['MaHoaDon']; ?></p>
            <p><strong>Người nhận:</strong> <?php echo $order['HoTen']; ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?php echo $order['DiaChiCuThe'] . ', ' . $order['PhuongXa'] . ', ' . $order['QuanHuyen'] . ', ' . $order['TPTinh']; ?></p>
            <p><strong>Tổng tiền:</strong> <?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</p>
            <p><strong>Hình thức thanh toán:</strong> <?php echo $order['PhuongThucThanhToan']; ?></p>

            <h5 class="mt-4">Chi tiết đơn hàng:</h5>
            <ul class="list-group">
                <?php foreach ($order_details as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $item['TenSanPham']; ?>
                        <span><?php echo $item['SoLuong']; ?> x <?php echo number_format($item['DonGia'], 0, ',', '.'); ?> VNĐ</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <a href="../index.php" class="btn-back-home">Quay lại trang chủ</a>
    </div>
</body>
</html>
