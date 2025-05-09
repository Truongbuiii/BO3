<?php
require 'includes/header.php';
require './db/connect.php';

$tennguoidung = $_GET['tennguoidung'];
$start_date = $_GET['start_date'] . " 00:00:00";
$end_date = $_GET['end_date'] . " 23:59:59";

$query = "
    SELECT HoaDon.MaHoaDon, HoaDon.NgayGio, HoaDon.TongTien, HoaDon.NguoiNhanHang, HoaDon.SoDienThoai
    FROM HoaDon
    WHERE HoaDon.NguoiNhanHang = ? AND HoaDon.NgayGio BETWEEN ? AND ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $tennguoidung, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid">
    <h3 class="text-center mt-4">Danh sách hóa đơn của khách hàng: <?= htmlspecialchars($tennguoidung) ?></h3>
    <h4 class="text-center">Từ ngày: <?= htmlspecialchars($_GET['start_date']) ?> đến ngày: <?= htmlspecialchars($_GET['end_date']) ?></h4>

  

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Ngày giờ</th>
                <th>Tổng tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>
</div>


<?php require 'includes/footer.php'; ?>