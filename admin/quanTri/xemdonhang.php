<?php
require 'includes/header.php';
require './db/connect.php';

// Lấy dữ liệu từ query string
$email = $_GET['email'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

// Truy vấn dữ liệu đơn hàng
$query = "
    SELECT MaHoaDon, Email, NguoiNhanHang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, NgayGio, TongTien, TrangThai, HinhThucThanhToan
    FROM HoaDon
    WHERE Email = ? AND NgayGio BETWEEN ? AND ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $email, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Kiểm tra nếu có dữ liệu đơn hàng
if ($order) {
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f2f6fc;
        padding: 20px;
        margin: 0;
    }

    .invoice {
        width: 60%;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .invoice-header h1 {
        font-size: 24px;
        color: #1a237e;
        margin-bottom: 5px;
    }

    .invoice-header p {
        margin: 2px 0;
        font-size: 14px;
        color: #333;
    }

    .invoice-details {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .invoice-details th,
    .invoice-details td {
        padding: 10px 8px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .invoice-details th {
        font-weight: bold;
        color: #1a237e;
        width: 35%;
        background-color: transparent;
    }

    .invoice-details td {
        color: #444;
        background-color: transparent;
    }

    .invoice-footer {
        text-align: right;
        margin-top: 15px;
    }

    .total {
        font-size: 16px;
        font-weight: bold;
        color: #1b5e20;
        margin-bottom: 10px;
    }

    button {
        background-color: #1e88e5;
        color: white;
        border: none;
        padding: 8px 16px;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #1565c0;
    }

    @media (max-width: 768px) {
        .invoice {
            width: 90%;
        }
    }
</style>


</head>
<body>

    <div class="invoice">
        <div class="invoice-header">
            <h1>Hóa Đơn Mua Hàng</h1>
        
        </div>

        <table class="invoice-details">
            <tr>
                <th>Mã Hóa Đơn</th>
                <td><?= htmlspecialchars($order['MaHoaDon']) ?></td>
            </tr>
            <tr>
                <th>Email khách hàng</th>
                <td><?= htmlspecialchars($order['Email']) ?></td>
            </tr>
            <tr>
                <th>Người nhận</th>
                <td><?= htmlspecialchars($order['NguoiNhanHang']) ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?= htmlspecialchars($order['DiaChiCuThe']) ?></td>
            </tr>
            <tr>
                <th>Ngày giờ</th>
                <td><?= htmlspecialchars($order['NgayGio']) ?></td>
            </tr>
            <tr>
                <th>Trạng thái</th>
                <td><?= htmlspecialchars($order['TrangThai']) ?></td>
            </tr>
            <tr>
                <th>Hình thức thanh toán</th>
                <td><?= htmlspecialchars($order['HinhThucThanhToan']) ?></td>
            </tr>
        </table>

        <div class="invoice-footer">
            <p class="total">Tổng tiền: <?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</p>
            <button onclick="window.print()">In Hóa Đơn</button>
        </div>
    </div>

</body>
</html>

<?php
} else {
    echo "<div class='alert alert-danger text-center'>Không tìm thấy hóa đơn.</div>";
}
?>

<?php require 'includes/footer.php'; ?>
