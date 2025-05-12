<?php
session_start();
require(__DIR__ . "/../db/connect.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Dữ liệu không hợp lệ.'); window.location.href='/index.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$cart = $_SESSION['cart'];
$ngayLap = date('Y-m-d H:i:s');

// Lấy dữ liệu từ form
$hoTen = $_POST['name'];
$email = $_POST['email'];
$sdt = $_POST['phone'];
$paymentMethod = $_POST['payment_method'];
$option = $_POST['address_option'];

if ($option === 'use_account') {
    $tinh = $_POST['city'];
    $huyen = $_POST['district'];
    $xa = $_POST['ward'];
    $diaChi = $_POST['address'];
} else {
    $tinh = $_POST['new_city'];
    $huyen = $_POST['new_district'];
    $xa = $_POST['new_ward'];
    $diaChi = $_POST['new_address_detail'];
}

// Kiểm tra thông tin quan trọng
if (empty($hoTen) || empty($email) || empty($sdt) || empty($diaChi)) {
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin.'); window.location.href='/trangThanhToan.php';</script>";
    exit();
}

// Tính tổng tiền
$tongTien = 0;
foreach ($cart as $item) {
    $tongTien += $item['DonGia'] * $item['quantity'];
}
$phiShip = 30000;
$tongThanhToan = $tongTien + $phiShip;

// === 1. Tạo hóa đơn ===
$sqlHD = "INSERT INTO HoaDon (TenNguoiDung, HoTen, Email, SoDienThoai, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, NgayLap, TongTien, PhuongThucThanhToan) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlHD);
$stmt->bind_param("sssssssssis", $username, $hoTen, $email, $sdt, $tinh, $huyen, $xa, $diaChi, $ngayLap, $tongThanhToan, $paymentMethod);

if (!$stmt->execute()) {
    error_log("Lỗi khi tạo hóa đơn: " . $stmt->error);
    echo "<script>alert('Lỗi khi lưu hóa đơn.'); window.location.href='/trangThanhToan.php';</script>";
    exit();
}

// Lấy mã hóa đơn vừa tạo
$maHoaDon = $stmt->insert_id;

// === 2. Lưu chi tiết hóa đơn ===
$sqlCT = "INSERT INTO ChiTietHoaDon (MaHoaDon, MaSanPham, SoLuong, DonGia) VALUES (?, ?, ?, ?)";
$stmtCT = $conn->prepare($sqlCT);

foreach ($cart as $item) {
    $maSP = $item['MaSanPham'];
    $soLuong = $item['quantity'];
    $donGia = $item['DonGia'];
    $stmtCT->bind_param("iiid", $maHoaDon, $maSP, $soLuong, $donGia);
    if (!$stmtCT->execute()) {
        error_log("Lỗi khi lưu chi tiết hóa đơn (MaSP: $maSP): " . $stmtCT->error);
        echo "<script>alert('Lỗi khi lưu chi tiết hóa đơn.'); window.location.href='/trangThanhToan.php';</script>";
        exit();
    }
}

// Xóa giỏ hàng
unset($_SESSION['cart']);

// Chuyển hướng tới trang hoàn tất đơn hàng
header("Location: trangHoanTatDonHang.php?maHoaDon=" . $maHoaDon);
exit();
?>
