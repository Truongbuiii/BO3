<?php
require 'includes/header.php';
require './db/connect.php'; // Kết nối cơ sở dữ liệu

$top_customers = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'] . " 00:00:00";
    $end_date = $_POST['end_date'] . " 23:59:59";

    $query = "
        SELECT MaHoaDon, Email, NguoiNhanHang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, NgayGio, SUM(TongTien) AS TongChiTieu, TrangThai, HinhThucThanhToan
        FROM HoaDon
        WHERE NgayGio BETWEEN ? AND ? AND TrangThai = 'Đã giao thành công'
        GROUP BY Email, NguoiNhanHang
        ORDER BY TongChiTieu DESC
        LIMIT 5
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $top_customers[] = $row;
    }
}
?>

<style>
    .table thead th {
        background-color: #007bff;
        color: white;
        text-align: center;
    }

    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table-responsive-custom {
        
        width: 100%;
    }

    @media (max-width: 768px) {
        .table-responsive-custom {
            display: block;
        }
    }
</style>

<div class="container-fluid"> <!-- Dùng container-fluid để mở rộng tối đa -->
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Thống kê 5 khách hàng mua nhiều nhất</h1>
            </div>
            <form method="post" class="user text-center">
                <div class="form-group">
                    <label>Từ ngày:</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Đến ngày:</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Thống kê</button>
            </form>

            <?php if (!empty($top_customers)): ?>
                <h3 class="text-center mt-4">Kết quả thống kê</h3>
                <div class="table-responsive-custom mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Email khách hàng</th>
                                <th>Tên người nhận</th>
                                <th>Thành Phố/Tỉnh</th>
                                <th>Quận/Huyện</th>
                                <th>Phường/Xã</th>
                                <th>Địa chỉ cụ thể</th>
                                <th>Ngày giờ</th>
                                <th>Tổng chi tiêu (VNĐ)</th>
                                <th>Trạng Thái</th>
                                <th>Hình thức thanh toán</th>
                                <th>Chi tiết đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_customers as $customer): ?>
                                <tr>
                                    <td><?= htmlspecialchars($customer['MaHoaDon']) ?></td>
                                    <td><?= htmlspecialchars($customer['Email']) ?></td>
                                    <td><?= htmlspecialchars($customer['NguoiNhanHang']) ?></td>
                                    <td><?= htmlspecialchars($customer['TPTinh']) ?></td>
                                    <td><?= htmlspecialchars($customer['QuanHuyen']) ?></td>
                                    <td><?= htmlspecialchars($customer['PhuongXa']) ?></td>
                                    <td><?= htmlspecialchars($customer['DiaChiCuThe']) ?></td>
                                    <td><?= htmlspecialchars($customer['NgayGio']) ?></td>
                                    <td><?= number_format($customer['TongChiTieu'], 0, ',', '.') ?> VNĐ</td>
                                    <td><?= htmlspecialchars($customer['TrangThai']) ?></td>
                                    <td><?= htmlspecialchars($customer['HinhThucThanhToan']) ?></td>
                                    <td>
                                        <a href="xemdonhang.php?email=<?= urlencode($customer['Email']) ?>&start_date=<?= urlencode($_POST['start_date']) ?>&end_date=<?= urlencode($_POST['end_date']) ?>" class="btn btn-info btn-sm">
                                            Xem đơn hàng
                                        </a>    
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <div class="alert alert-warning mt-4 text-center">Không có dữ liệu trong khoảng thời gian này.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
