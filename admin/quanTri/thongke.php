<?php
require 'includes/header.php';
require './db/connect.php';

$start_date = $end_date = "";
$top_products = [];
$top_customers = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'] . " 00:00:00";
    $end_date = $_GET['end_date'] . " 23:59:59";

    // Thống kê theo mặt hàng
    $query_products = "
        SELECT SanPham.TenSanPham, SUM(ChiTietHoaDon.SoLuong) AS SoLuongBan, SUM(ChiTietHoaDon.SoLuong * ChiTietHoaDon.DonGia) AS DoanhThu, SanPham.MaSanPham
        FROM HoaDon
        JOIN ChiTietHoaDon ON HoaDon.MaHoaDon = ChiTietHoaDon.MaHoaDon
        JOIN SanPham ON ChiTietHoaDon.MaSanPham = SanPham.MaSanPham
        WHERE NgayGio BETWEEN ? AND ?
        GROUP BY SanPham.MaSanPham
        ORDER BY DoanhThu DESC
    ";

    $query_customers = "
        SELECT HoaDon.Email, HoaDon.NguoiNhanHang, SUM(ChiTietHoaDon.SoLuong * ChiTietHoaDon.DonGia) AS TongChiTieu
        FROM HoaDon
        JOIN ChiTietHoaDon ON HoaDon.MaHoaDon = ChiTietHoaDon.MaHoaDon
        WHERE HoaDon.NgayGio BETWEEN ? AND ?
        GROUP BY HoaDon.Email
        ORDER BY TongChiTieu DESC
        LIMIT 5
    ";

    $stmt_products = $conn->prepare($query_products);
    $stmt_products->bind_param("ss", $start_date, $end_date);
    $stmt_products->execute();
    $result_products = $stmt_products->get_result();
    while ($row = $result_products->fetch_assoc()) {
        $top_products[] = $row;
    }

    $stmt_customers = $conn->prepare($query_customers);
    $stmt_customers->bind_param("ss", $start_date, $end_date);
    $stmt_customers->execute();
    $result_customers = $stmt_customers->get_result();
    while ($row = $result_customers->fetch_assoc()) {
        $top_customers[] = $row;
    }
}
?>

<div class="container-fluid">
    <form method="GET" class="user text-center">
        <div class="form-group">
            <label>Từ ngày:</label>
            <input type="date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label>Đến ngày:</label>
            <input type="date" name="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Thống kê</button>
    </form>
</div>

<?php if (!empty($top_products)): ?>
    <div class="container-fluid">
        <h3 class="text-center mt-4">Thống kê Mặt Hàng</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng bán</th>
                    <th>Doanh thu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_revenue = 0;
                $best_selling = $top_products[0];
                $worst_selling = $top_products[count($top_products)-1];
                foreach ($top_products as $product): 
                    $total_revenue += $product['DoanhThu'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars($product['TenSanPham']) ?></td>
                        <td><?= htmlspecialchars($product['SoLuongBan']) ?></td>
                        <td><?= number_format($product['DoanhThu'], 0, ',', '.') ?> VNĐ</td>
                        <td><a class="btn" href="xemdonhangtheomathang.php?MaSanPham=<?= urlencode($product['MaSanPham']) ?>">Xem hóa đơn</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center">
            <p><strong>Tổng doanh thu: <?= number_format($total_revenue, 0, ',', '.') ?> VNĐ</strong></p>
            <p><strong>Sản phẩm bán chạy nhất: <?= $best_selling['TenSanPham'] ?> (<?= number_format($best_selling['DoanhThu'], 0, ',', '.') ?> VNĐ)</strong></p>
            <p><strong>Sản phẩm ế nhất: <?= $worst_selling['TenSanPham'] ?> (<?= number_format($worst_selling['DoanhThu'], 0, ',', '.') ?> VNĐ)</strong></p>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($top_customers)): ?>
    <div class="container-fluid">
        <h3 class="text-center mt-4">Top 5 Khách Hàng Chi Tiêu Nhiều Nhất</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Tên người nhận</th>
                    <th>Tổng chi tiêu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($top_customers as $customer): ?>
                    <tr>
                        <td><?= htmlspecialchars($customer['Email']) ?></td>
                        <td><?= htmlspecialchars($customer['NguoiNhanHang']) ?></td>
                        <td><?= number_format($customer['TongChiTieu'], 0, ',', '.') ?> VNĐ</td>
                        <td>
                            <a class="btn" href="xemdonhang.php?tennguoidung=<?= urlencode($customer['NguoiNhanHang']) ?>&start_date=<?= urlencode($_GET['start_date']) ?>&end_date=<?= urlencode($_GET['end_date']) ?>">
                                Xem hóa đơn
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
