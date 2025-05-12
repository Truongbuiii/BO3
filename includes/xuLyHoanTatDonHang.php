<?php
session_start();
require(__DIR__ . "/../db/connect.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Dữ liệu không hợp lệ.'); window.location.href='trangThanhToan.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$cart = $_SESSION['cart'];
$ngayLap = date('Y-m-d H:i:s');

$hoTen = $_POST['name'];
$email = $_POST['email'];
$sdt = $_POST['phone'];
$paymentMethod = $_POST['payment-method'];
$option = $_POST['address-option'];

if ($option === 'use-account') {
    $tinh = $_POST['city'];
    $huyen = $_POST['district'];
    $xa = $_POST['ward'];
    $diaChi = $_POST['address'];
} else {
    $tinh = $_POST['new-city'];
    $huyen = $_POST['new-district'];
    $xa = $_POST['new-ward'];
    $diaChi = $_POST['new-address-detail'];
}
error_log("DEBUG: HoTen=$hoTen, Email=$email, SDT=$sdt, DiaChi=$diaChi");


if (empty($hoTen) || empty($email) || empty($sdt) || empty($diaChi)) {
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin.'); window.location.href='trangThanhToan.php';</script>";
    exit();
}

$tongTien = 0;
foreach ($cart as $item) {
    $tongTien += $item['DonGia'] * $item['quantity'];
}
$phiShip = 30000;
$tongThanhToan = $tongTien + $phiShip;
// Lấy mã hóa đơn mới từ cơ sở dữ liệu
$result = $conn->query("SELECT MaHoaDon FROM HoaDon ORDER BY MaHoaDon DESC LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Kiểm tra xem mã hóa đơn có đúng format không
    $lastMaHD = $row['MaHoaDon'];
    $number = (int)substr($lastMaHD, 2); // Giả sử mã hóa đơn có định dạng 'HDxxx'
    $newNumber = $number + 1;
    $maHoaDon = 'HD' . str_pad($newNumber, 3, '0', STR_PAD_LEFT); // Tạo mã hóa đơn mới
} else {
    // Nếu không có mã hóa đơn trước đó, khởi tạo mã hóa đơn đầu tiên
    $maHoaDon = 'HD001';
}


$sqlHD = "INSERT INTO HoaDon (MaHoaDon, TenNguoiDung, HoTen, Email, SoDienThoai, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, NgayLap, TongTien, PhuongThucThanhToan)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlHD);
$stmt->bind_param("ssssssssssis", $maHoaDon, $username, $hoTen, $email, $sdt, $tinh, $huyen, $xa, $diaChi, $ngayLap, $tongThanhToan, $paymentMethod);

if (!$stmt->execute()) {
    error_log("Lỗi khi tạo hóa đơn: " . $stmt->error);
    echo "<script>alert('Lỗi khi lưu hóa đơn.'); window.location.href='trangThanhToan.php';</script>";
    exit();
}

$sqlCT = "INSERT INTO ChiTietHoaDon (MaHoaDon, MaSanPham, SoLuong, DonGia) VALUES (?, ?, ?, ?)";
$stmtCT = $conn->prepare($sqlCT);

foreach ($cart as $item) {
    $maSP = $item['MaSanPham'];
    $soLuong = $item['quantity'];
    $donGia = $item['DonGia'];
    $stmtCT->bind_param("siid", $maHoaDon, $maSP, $soLuong, $donGia);
    
    if (!$stmtCT->execute()) {
        error_log("Lỗi khi lưu chi tiết hóa đơn (MaSP: $maSP): " . $stmtCT->error);
        echo "<script>alert('Lỗi khi lưu chi tiết hóa đơn.'); window.location.href='trangThanhToan.php';</script>";
        exit();
    }
}

unset($_SESSION['cart']);
error_log("✅ Mã hóa đơn được tạo: " . $maHoaDon);

// 👉 ĐÂY là phần quan trọng
header("Location: hoanTatDonHang.php?maHoaDon=" . urlencode($maHoaDon));
exit();
?>