<?php
require 'includes/header.php';
require './db/connect.php';

// Bật hiển thị lỗi chi tiết (chỉ dùng khi phát triển)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Kiểm tra kết nối CSDL
if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu từ URL và xử lý an toàn
$tennguoidung = isset($_GET['tennguoidung']) ? $_GET['tennguoidung'] : '';
$start_date_raw = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date_raw = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$start_date = $start_date_raw . " 00:00:00";
$end_date = $end_date_raw . " 23:59:59";

// Câu lệnh SQL có sử dụng prepared statement
$query = "
    SELECT HoaDon.MaHoaDon, HoaDon.NgayGio, HoaDon.TongTien, HoaDon.NguoiNhanHang, HoaDon.SoDienThoai
    FROM HoaDon
    WHERE HoaDon.NguoiNhanHang = ? AND HoaDon.NgayGio BETWEEN ? AND ?
";

// Chuẩn bị truy vấn
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Lỗi khi chuẩn bị truy vấn: " . $conn->error);
}

// Gán tham số
$stmt->bind_param("sss", $tennguoidung, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid">
    <h3 class="text-center mt-4">
        Danh sách hóa đơn của khách hàng: <?= htmlspecialchars($tennguoidung) ?>
    </h3>
    <h4 class="text-center">
        Từ ngày: <?= htmlspecialchars($start_date_raw) ?> đến ngày: <?= htmlspecialchars($end_date_raw) ?>
    </h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Ngày giờ</th>
                <th>Tổng tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['MaHoaDon']) ?></td>
                        <td><?= htmlspecialchars($row['NgayGio']) ?></td>
                        <td><?= number_format($row['TongTien'], 0, ',', '.') ?> VNĐ</td>
                        <td>
                            <a href="chitiethoadon.php?MaHoaDon=<?= urlencode($row['MaHoaDon']) ?>" class="btn btn-outline-primary">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Không tìm thấy hóa đơn nào trong khoảng thời gian đã chọn.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$stmt->close();
$conn->close();
require 'includes/footer.php';
?>
