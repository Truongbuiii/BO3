<?php
require 'includes/header.php';
require './db/connect.php';

// Kiểm tra và lấy tham số 'tennguoidung' và khoảng thời gian
if (
    isset($_GET['tennguoidung'], $_GET['start_date'], $_GET['end_date']) &&
    trim($_GET['tennguoidung']) !== '' &&
    trim($_GET['start_date']) !== '' &&
    trim($_GET['end_date']) !== ''
) {
    $tennguoidung = trim($_GET['tennguoidung']);
    $start_date = trim($_GET['start_date']);
    $end_date = trim($_GET['end_date']);

    // Debug thông tin tham số để kiểm tra
    echo "<div>Tên người dùng: $tennguoidung</div>";
    echo "<div>Start Date: $start_date</div>";
    echo "<div>End Date: $end_date</div>";
} else {
    echo "<div class='alert alert-danger text-center'>Vui lòng cung cấp đầy đủ thông tin: tên người dùng và khoảng thời gian.</div>";
    exit;
}


// Truy vấn dữ liệu đơn hàng theo tên người dùng (thay vì email)
$query = "
    SELECT MaHoaDon, Email, NguoiNhanHang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, NgayGio, TongTien, TrangThai, HinhThucThanhToan
    FROM HoaDon
    WHERE Email IN (SELECT Email FROM NguoiDung WHERE TenNguoiDung = ?) AND NgayGio BETWEEN ? AND ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $tennguoidung, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu có dữ liệu đơn hàng
if ($result->num_rows > 0) {
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

        .invoice-list {
            width: 80%;
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

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 10px 8px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .invoice-table th {
            font-weight: bold;
            color: #1a237e;
        }

        .invoice-table td {
            color: #444;
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
            .invoice-list {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-list">
        <div class="invoice-header">
            <h1>Danh Sách Hóa Đơn</h1>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Mã Hóa Đơn</th>
                    <th>Ngày Giờ</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Hình Thức Thanh Toán</th>
                    <th>Xem Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($order['MaHoaDon']) ?></td>
                        <td><?= htmlspecialchars($order['NgayGio']) ?></td>
                        <td><?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= htmlspecialchars($order['TrangThai']) ?></td>
                        <td><?= htmlspecialchars($order['HinhThucThanhToan']) ?></td>
                        <td><a href="xemchitiet.php?mahoadon=<?= $order['MaHoaDon'] ?>">Xem</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="invoice-footer">
            <p class="total">Tổng Tiền: <?= number_format($totalRevenue, 0, ',', '.') ?> VNĐ</p>
            <button onclick="window.print()">In Danh Sách Hóa Đơn</button>
        </div>
    </div>

</body>
</html>

<?php
} else {
    echo "<div class='alert alert-danger text-center'>Không tìm thấy hóa đơn trong khoảng thời gian đã chọn.</div>";
}
?>

<?php require 'includes/footer.php'; ?>
