<?php
session_start();
require(__DIR__ . "/../db/connect.php");

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['payment-method']) || !isset($_POST['address-option'])) {
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
    if ($option === 'enter-new' && (empty($tinh) || empty($huyen) || empty($xa) || empty($diaChi))) {
        echo "<script>alert('Vui lòng nhập đầy đủ địa chỉ mới.'); window.location.href='trangThanhToan.php';</script>";
        exit();
    }
    
}



if (empty($hoTen) || empty($email) || empty($sdt) || empty($diaChi)) {
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin.');</script>";
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


$sqlHD = "INSERT INTO HoaDon (MaHoaDon, TenNguoiDung, NguoiNhanHang, Email, SoDienThoai, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, NgayGio, TongTien, HinhThucThanhToan)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlHD);
$stmt->bind_param("ssssssssssds", $maHoaDon, $username, $hoTen, $email, $sdt, $tinh, $huyen, $xa, $diaChi, $ngayLap, $tongThanhToan, $paymentMethod);

if (!$stmt->execute()) {
    error_log("Lỗi khi tạo hóa đơn: " . $stmt->error);
    echo "<script>alert('Lỗi khi lưu hóa đơn.'); window.location.href='trangThanhToan.php';</script>";
    exit();
}



// Kiểm tra xem giỏ hàng có trống hay không
if (empty($cart)) {
    error_log("Giỏ hàng trống hoặc không có sản phẩm hợp lệ.");
    exit();
}

// Kiểm tra mã hóa đơn đã được tạo chưa
if (empty($maHoaDon)) {
    error_log("Mã hóa đơn không được tạo.");
    exit();
}

$sqlCT = "INSERT INTO ChiTietHoaDon (MaHoaDon, MaSanPham, SoLuong, DonGia) VALUES (?, ?, ?, ?)";
$stmtCT = $conn->prepare($sqlCT);

// Kiểm tra kết nối SQL
if (!$stmtCT) {
    error_log("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    exit();
}
foreach ($_SESSION['cart'] as $maSanPham => $item) {
    // Tính giá tiền của sản phẩm này
    $donGia = $item['DonGia']; // Giá tại thời điểm mua
    $soLuong = $item['quantity']; // Số lượng sản phẩm
    
    // Chèn dữ liệu vào bảng ChiTietHoaDon
    $sql = "INSERT INTO ChiTietHoaDon (MaHoaDon, MaSanPham, SoLuong, DonGia) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssid", $maHoaDon, $maSanPham, $soLuong, $donGia);
    
    if ($stmt->execute()) {
        echo "Sản phẩm đã được thêm vào chi tiết hóa đơn.";
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

// Lưu giỏ hàng và xóa sau khi lưu hóa đơn
error_log("✅ Mã hóa đơn được tạo: " . $maHoaDon);

// Kiểm tra giỏ hàng sau khi thanh toán
if (isset($_SESSION['cart'])) {
    error_log("Giỏ hàng hiện tại: " . print_r($_SESSION['cart'], true));
} else {
    error_log("Giỏ hàng trống.");
}

// Xóa giỏ hàng sau khi lưu hóa đơn thành công
unset($_SESSION['cart']);

// Chuyển hướng sau khi lưu hóa đơn thành công
header("Location: hoanTatDonHang.php?maHoaDon=" . urlencode($maHoaDon));
exit();
