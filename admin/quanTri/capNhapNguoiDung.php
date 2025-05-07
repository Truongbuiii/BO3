<?php
require('./db/connect.php');

// Hàm kiểm tra trùng lặp email
function checkDuplicateEmail($email, $tenNguoiDung, $conn) {
    $sqlCheckEmail = "SELECT COUNT(*) FROM NguoiDung WHERE Email = ? AND TenNguoiDung != ?";
    $stmtCheckEmail = $conn->prepare($sqlCheckEmail);
    $stmtCheckEmail->bind_param("ss", $email, $tenNguoiDung);
        $count = 0;
    $stmtCheckEmail->execute();
    $stmtCheckEmail->bind_result($count);
    $stmtCheckEmail->fetch();
    $stmtCheckEmail->close();
    return $count > 0;
}

// Hàm kiểm tra trùng lặp số điện thoại
function checkDuplicatePhone($soDienThoai, $tenNguoiDung, $conn) {
    $sqlCheckPhone = "SELECT COUNT(*) FROM NguoiDung WHERE SoDienThoai = ? AND TenNguoiDung != ?";
    $stmtCheckPhone = $conn->prepare($sqlCheckPhone);
    $stmtCheckPhone->bind_param("ss", $soDienThoai, $tenNguoiDung);
    $stmtCheckPhone->execute();
        $count = 0;

    $stmtCheckPhone->bind_result($count);
    $stmtCheckPhone->fetch();
    $stmtCheckPhone->close();
    return $count > 0;
}

// Lấy dữ liệu từ client
$data = json_decode(file_get_contents("php://input"), true);
$tenNguoiDung = $data['TenNguoiDung'] ?? '';
$hoTen = $data['HoTen'] ?? '';
$email = $data['Email'] ?? '';
$matKhau = $data['MatKhau'] ?? '';
$soDienThoai = $data['SoDienThoai'] ?? '';
$vaitro = $data['VaiTro'] ?? '';
$tinhTrang = $data['TinhTrang'] ?? '';
$tptinh = $data['TPTinh'] ?? '';
$quanHuyen = $data['QuanHuyen'] ?? '';
$phuongXa = $data['PhuongXa'] ?? '';
$diaChiCuThe = $data['DiaChiCuThe'] ?? '';

// Kiểm tra trùng email hoặc số điện thoại
if (checkDuplicateEmail($email, $tenNguoiDung, $conn)) {
    echo "Email này đã được sử dụng. Vui lòng nhập lại email khác.";
    exit;
}
if (checkDuplicatePhone($soDienThoai, $tenNguoiDung, $conn)) {
    echo "Số điện thoại này đã được sử dụng. Vui lòng nhập lại số điện thoại khác.";
    exit;
}

// Trước khi cập nhật, kiểm tra nếu người dùng đang bị khóa
$sqlCheckStatus = "SELECT TinhTrang FROM NguoiDung WHERE TenNguoiDung = ?";
$stmtCheck = $conn->prepare($sqlCheckStatus);
$stmtCheck->bind_param("s", $tenNguoiDung);
$stmtCheck->execute();
$stmtCheck->bind_result($currentTinhTrang);
$stmtCheck->fetch();
$stmtCheck->close();

if ($currentTinhTrang === 'Khóa') {
    // Nếu chỉ muốn cập nhật tình trạng để mở khóa
    if ($tinhTrang !== 'Khóa') {
        $sqlUnlock = "UPDATE NguoiDung SET TinhTrang = ? WHERE TenNguoiDung = ?";
        $stmt = $conn->prepare($sqlUnlock);
        $stmt->bind_param("ss", $tinhTrang, $tenNguoiDung);
        if ($stmt->execute()) {
            echo "Đã mở khóa người dùng thành công!";
        } else {
            echo "Lỗi khi mở khóa người dùng: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Không thể cập nhật người dùng đang bị khóa, trừ khi mở khóa.";
    }
    $conn->close();
    exit;
}


// Cập nhật thông tin người dùng (kể cả Tình Trạng)
if (!empty($matKhau)) {
    $matKhauHash = password_hash($matKhau, PASSWORD_DEFAULT);
    $sql = "UPDATE NguoiDung SET 
                HoTen = ?, 
                Email = ?, 
                MatKhau = ?, 
                SoDienThoai = ?, 
                VaiTro = ?, 
                TinhTrang = ?, 
                TPTinh = ?, 
                QuanHuyen = ?, 
                PhuongXa = ?, 
                DiaChiCuThe = ? 
            WHERE TenNguoiDung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $hoTen, $email, $matKhauHash, $soDienThoai, $vaitro, $tinhTrang, $tptinh, $quanHuyen, $phuongXa, $diaChiCuThe, $tenNguoiDung);
} else {
    $sql = "UPDATE NguoiDung SET 
                HoTen = ?, 
                Email = ?, 
                SoDienThoai = ?, 
                VaiTro = ?, 
                TinhTrang = ?, 
                TPTinh = ?, 
                QuanHuyen = ?, 
                PhuongXa = ?, 
                DiaChiCuThe = ? 
            WHERE TenNguoiDung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $hoTen, $email, $soDienThoai, $vaitro, $tinhTrang, $tptinh, $quanHuyen, $phuongXa, $diaChiCuThe, $tenNguoiDung);
}

// Thực thi và phản hồi
if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật người dùng: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
