<?php
require 'includes/header.php';
require './db/connect.php'; // Kết nối cơ sở dữ liệu

// Lấy mã hóa đơn và mã sản phẩm từ URL
$MaHoaDon = isset($_GET['MaHoaDon']) ? $_GET['MaHoaDon'] : '';
$MaSanPham = isset($_GET['MaSanPham']) ? $_GET['MaSanPham'] : '';

// Nếu mã hóa đơn được truyền vào, lấy thông tin chi tiết hóa đơn
if ($MaHoaDon != '') {
    // Truy vấn lấy chi tiết hóa đơn theo mã hóa đơn
    $query = "
        SELECT HoaDon.MaHoaDon, HoaDon.Email, HoaDon.NguoiNhanHang, HoaDon.NgayGio, ChiTietHoaDon.MaSanPham, ChiTietHoaDon.SoLuong, ChiTietHoaDon.DonGia, (ChiTietHoaDon.SoLuong * ChiTietHoaDon.DonGia) AS ThanhTien
        FROM HoaDon
        JOIN ChiTietHoaDon ON HoaDon.MaHoaDon = ChiTietHoaDon.MaHoaDon
        WHERE HoaDon.MaHoaDon = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $MaHoaDon);
    $stmt->execute();
    $result = $stmt->get_result();
}
elseif ($MaSanPham != '') {
    // Truy vấn lấy danh sách hóa đơn theo mặt hàng
    $query = "
        SELECT HoaDon.MaHoaDon, HoaDon.Email, HoaDon.NguoiNhanHang, HoaDon.NgayGio, ChiTietHoaDon.SoLuong, ChiTietHoaDon.DonGia, (ChiTietHoaDon.SoLuong * ChiTietHoaDon.DonGia) AS ThanhTien
        FROM HoaDon
        JOIN ChiTietHoaDon ON HoaDon.MaHoaDon = ChiTietHoaDon.MaHoaDon
        WHERE ChiTietHoaDon.MaSanPham = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $MaSanPham);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<div class="container-fluid">
    <h3 class="text-center mt-4">Chi Tiết Hóa Đơn</h3>
    
    <?php if ($MaHoaDon != ''): ?>
        <h4>Mã Hóa Đơn: <?= htmlspecialchars($MaHoaDon) ?></h4>
    <?php endif; ?>

    <?php if ($MaSanPham != ''): ?>
        <h4>Mã Sản Phẩm: <?= htmlspecialchars($MaSanPham) ?></h4>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã Hóa Đơn</th>
                <th>Email Khách Hàng</th>
                <th>Tên Người Nhận</th>
                <th>Ngày Giờ</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['MaHoaDon']) ?></td>
                    <td><?= htmlspecialchars($row['Email']) ?></td>
                    <td><?= htmlspecialchars($row['NguoiNhanHang']) ?></td>
                    <td><?= htmlspecialchars($row['NgayGio']) ?></td>
                    <td><?= htmlspecialchars($row['SoLuong']) ?></td>
                    <td><?= number_format($row['DonGia'], 0, ',', '.') ?> VNĐ</td>
                    <td><?= number_format($row['ThanhTien'], 0, ',', '.') ?> VNĐ</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
// Đóng kết nối
$stmt->close();
?>
