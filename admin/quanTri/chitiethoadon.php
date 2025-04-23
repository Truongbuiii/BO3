<?php
require('includes/header.php');
require('./db/connect.php');

$maHD = $_GET['MaHoaDon'] ?? null;

if (!$maHD) {
    die("Thiếu mã hóa đơn.");
}

// Lấy thông tin hóa đơn
$sql = "SELECT * FROM hoadon WHERE MaHoaDon = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maHD);
$stmt->execute();
$result = $stmt->get_result();
$hoaDon = $result->fetch_assoc();

if (!$hoaDon) {
    die("Không tìm thấy hóa đơn.");
}

// Lấy chi tiết sản phẩm trong hóa đơn
$sql_ct = "SELECT cthd.*, sp.TenSanPham 
           FROM chitiethoadon cthd 
           JOIN sanpham sp ON cthd.MaSanPham = sp.MaSanPham 
           WHERE cthd.MaHoaDon = ?";
$stmt_ct = $conn->prepare($sql_ct);
$stmt_ct->bind_param("s", $maHD);
$stmt_ct->execute();
$result_ct = $stmt_ct->get_result();
$chiTietSanPham = $result_ct->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-box {
            background: #fff;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .top-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .top-section div {
            width: 48%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .totals {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Chi tiết đơn hàng - <?= htmlspecialchars($hoaDon['MaHoaDon']) ?></h2>
    
    <div class="invoice-box">
        <h1>HÓA ĐƠN</h1>

        <div class="top-section">
            <div class="billed-to">
                <strong>Người nhận:</strong><br>

            <strong>Họ tên người nhận : <?= htmlspecialchars($hoaDon['NguoiNhanHang']) ?></strong><br>
                <?= htmlspecialchars($hoaDon['Email']) ?><br>
                <?= "{$hoaDon['DiaChiCuThe']}, {$hoaDon['PhuongXa']}, {$hoaDon['QuanHuyen']}, {$hoaDon['TPTinh']}" ?>
            </div>
            <div class="invoice-info">
                <strong>Mã hóa đơn:</strong> <?= htmlspecialchars($hoaDon['MaHoaDon']) ?><br>
                <strong>Ngày giờ:</strong> <?= htmlspecialchars($hoaDon['NgayGio']) ?><br>
                <strong>Thanh toán:</strong> <?= htmlspecialchars($hoaDon['HinhThucThanhToan']) ?><br>
                <strong>Trạng thái:</strong> <?= htmlspecialchars($hoaDon['TrangThai']) ?>
            </div>
        </div>

        <table>
            <thead>
            <tr>
                <th>Sản phẩm</th>
                <th style="text-align: center;">SL</th>
                <th style="text-align: right;">Đơn giá</th>
                <th style="text-align: right;">Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($chiTietSanPham as $sp): ?>
                <tr>
                    <td><?= htmlspecialchars($sp['TenSanPham']) ?></td>
                    <td style="text-align: center;"><?= $sp['SoLuong'] ?></td>
                    <td style="text-align: right;"><?= number_format($sp['DonGia'], 0, ',', '.') ?>đ</td>
                    <td style="text-align: right;"><?= number_format($sp['SoLuong'] * $sp['DonGia'], 0, ',', '.') ?>đ</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="totals">
            Tổng cộng: <?= number_format($hoaDon['TongTien'], 0, ',', '.') ?>đ
        </div>
    </div>

    <div class="text-end mt-3">
        <a href="danhsachdonhang.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php require('includes/footer.php'); ?>
