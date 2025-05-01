<?php
require('./db/connect.php');

// Hàm kiểm tra trùng lặp email
function checkDuplicateEmail($email, $tenNguoiDung, $conn) {
    $sqlCheckEmail = "SELECT COUNT(*) FROM NguoiDung WHERE Email = ? AND TenNguoiDung != ?";
    $stmtCheckEmail = $conn->prepare($sqlCheckEmail);
    $stmtCheckEmail->bind_param("ss", $email, $tenNguoiDung);
    $stmtCheckEmail->execute();
    $count = 0;
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

// Lấy dữ liệu từ form
$tenNguoiDung = isset($_POST['TenNguoiDung']) ? $_POST['TenNguoiDung'] : '';
$hoTen = isset($_POST['HoTen']) ? $_POST['HoTen'] : '';
$email = isset($_POST['Email']) ? $_POST['Email'] : '';
$matKhau = isset($_POST['MatKhau']) ? $_POST['MatKhau'] : '';
$soDienThoai = isset($_POST['SoDienThoai']) ? $_POST['SoDienThoai'] : '';
$vaitro = isset($_POST['VaiTro']) ? $_POST['VaiTro'] : '';
$tinhTrang = isset($_POST['TinhTrang']) ? $_POST['TinhTrang'] : '';
$tptinh = isset($_POST['TPTinh']) ? $_POST['TPTinh'] : '';
$quanHuyen = isset($_POST['QuanHuyen']) ? $_POST['QuanHuyen'] : '';
$phuongXa = isset($_POST['PhuongXa']) ? $_POST['PhuongXa'] : '';
$diaChiCuThe = isset($_POST['DiaChiCuThe']) ? $_POST['DiaChiCuThe'] : '';

// Kiểm tra nếu email đã tồn tại trong cơ sở dữ liệu
if (checkDuplicateEmail($email, $tenNguoiDung, $conn)) {
    echo "Email này đã được sử dụng. Vui lòng nhập lại email khác.";
    exit;
}

// Kiểm tra nếu số điện thoại đã tồn tại trong cơ sở dữ liệu
if (checkDuplicatePhone($soDienThoai, $tenNguoiDung, $conn)) {
    echo "Số điện thoại này đã được sử dụng. Vui lòng nhập lại số điện thoại khác.";
    exit;
}

// Kiểm tra tình trạng người dùng
if ($tinhTrang === 'Khóa') {
    // Cập nhật tình trạng người dùng thành "Khóa"
    $sql = "UPDATE NguoiDung SET TinhTrang = ? WHERE TenNguoiDung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tinhTrang, $tenNguoiDung);
    $stmt->execute();
    echo "Người dùng đã bị khóa thành công!";
} else {
    // Nếu tình trạng không phải là "Khóa", thực hiện cập nhật thông tin người dùng
    if ($matKhau != '') {
        // Mã hóa mật khẩu nếu có
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
}

// Thực thi câu lệnh và thông báo kết quả
if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật người dùng: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
