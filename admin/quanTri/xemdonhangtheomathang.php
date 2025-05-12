<?php
require 'includes/header.php';
require './db/connect.php'; // Kết nối cơ sở dữ liệu

// Lấy mã hóa đơn và mã sản phẩm từ URL và sanitize
$MaHoaDon = isset($_GET['MaHoaDon']) ? htmlspecialchars($_GET['MaHoaDon']) : '';
$MaSanPham = isset($_GET['MaSanPham']) ? htmlspecialchars($_GET['MaSanPham']) : '';

// Kiểm tra điều kiện có mã hóa đơn hoặc mã sản phẩm
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
else {
    echo "Vui lòng cung cấp mã hóa đơn hoặc mã sản phẩm để xem chi tiết.";
    exit;
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

    <?php if ($result->num_rows > 0): ?>
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
                        <td><?= date('d-m-Y H:i', strtotime($row['NgayGio'])) ?></td>
                        <td><?= htmlspecialchars($row['SoLuong']) ?></td>
                        <td><?= number_format($row['DonGia'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= number_format($row['ThanhTien'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Không có dữ liệu để hiển thị.</p>
    <?php endif; ?>

    <?php
    require 'includes/footer.php';
    ?>

<?php
// Đóng kết nối
$stmt->close();
?>
