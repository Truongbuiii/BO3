<?php
session_start();
require(__DIR__ . "/../db/connect.php");

// Xóa phần debug print_r($_GET) vì nó có thể gây lỗi header()

// Kiểm tra mã hóa đơn với regex để đảm bảo định dạng
if (isset($_GET['maHoaDon']) && preg_match('/^HD\d{3}$/', $_GET['maHoaDon'])) {
    $maHoaDon = $conn->real_escape_string($_GET['maHoaDon']); // Làm sạch mã hóa đơn
    error_log("Mã hóa đơn nhận được: " . $maHoaDon);
} else {
    error_log("Mã hóa đơn không hợp lệ: " . ($_GET['maHoaDon'] ?? ''));
    echo "<script>
        alert('Mã hóa đơn không hợp lệ'); 
        window.location.href='/index.php';
    </script>";
    exit;
}

// Lấy thông tin hóa đơn từ CSDL với JOIN để lấy thông tin người dùng
$sql = "SELECT hd.*, nd.HoTen AS NguoiNhanHang 
        FROM HoaDon hd
        LEFT JOIN NguoiDung nd ON hd.TenNguoiDung = nd.TenDangNhap
        WHERE hd.MaHoaDon = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maHoaDon);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('Không tìm thấy đơn hàng!'); 
        window.location.href='/index.php';
    </script>";
    exit;
}

$order = $result->fetch_assoc();

// Truy vấn chi tiết sản phẩm với hình ảnh
$sql_ct = "SELECT cthd.SoLuong, cthd.DonGia, sp.TenSanPham, sp.HinhAnh 
        FROM ChiTietHoaDon cthd 
        JOIN SanPham sp ON cthd.MaSanPham = sp.MaSanPham 
        WHERE cthd.MaHoaDon = ?";

$stmt_ct = $conn->prepare($sql_ct);
$stmt_ct->bind_param("s", $maHoaDon);
$stmt_ct->execute();
$result_ct = $stmt_ct->get_result();

if ($result_ct->num_rows === 0) {
    echo "<script>
        alert('Không có sản phẩm trong hóa đơn!'); 
        window.location.href='/index.php';
    </script>";
    exit;
}

$order_details = $result_ct->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoàn tất đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffe6ec, #e3f6f5);
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }
        .thankyou-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            max-width: 800px;
            margin: 0 auto;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="thankyou-container">
        <div class="text-center mb-4">
            <i class="fa-solid fa-circle-check text-success" style="font-size: 60px;"></i>
            <h2 class="mt-3">Đơn hàng đã được đặt thành công!</h2>
            <p>Cảm ơn bạn đã mua hàng. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h4>Thông tin đơn hàng</h4>
                <p><strong>Mã hóa đơn:</strong> <?= htmlspecialchars($order['MaHoaDon']) ?></p>
                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['NgayLap'])) ?></p>
                <p><strong>Tổng tiền:</strong> <?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</p>
                <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['PhuongThucThanhToan']) ?></p>
            </div>
            <div class="col-md-6">
                <h4>Thông tin giao hàng</h4>
                <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['NguoiNhanHang']) ?></p>
                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['DiaChiCuThe']) ?>, <?= htmlspecialchars($order['PhuongXa']) ?>, <?= htmlspecialchars($order['QuanHuyen']) ?>, <?= htmlspecialchars($order['TPTinh']) ?></p>
                <p><strong>Điện thoại:</strong> <?= htmlspecialchars($order['SoDienThoai']) ?></p>
            </div>
        </div>

        <h5 class="mt-4">Chi tiết đơn hàng</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_details as $item): ?>
                <tr>
                    <td>
                        <img src="../images/<?= htmlspecialchars($item['HinhAnh']) ?>" class="product-img me-2">
                        <?= htmlspecialchars($item['TenSanPham']) ?>
                    </td>
                    <td><?= number_format($item['DonGia'], 0, ',', '.') ?> VNĐ</td>
                    <td><?= $item['SoLuong'] ?></td>
                    <td><?= number_format($item['DonGia'] * $item['SoLuong'], 0, ',', '.') ?> VNĐ</td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                    <td>30.000 VNĐ</td>
                </tr>
                <tr class="table-active">
                    <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                    <td><strong><?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="../index.php" class="btn btn-primary px-4 py-2">Quay lại trang chủ</a>
            <a href="#" class="btn btn-outline-secondary px-4 py-2 ms-2">In hóa đơn</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>