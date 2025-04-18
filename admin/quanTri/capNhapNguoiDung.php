<?php
require('./db/connect.php');

// Hàm kiểm tra trùng lặp email
function checkDuplicateEmail($email, $tenNguoiDung, $conn) {
    // Câu lệnh SQL kiểm tra email
    $sqlCheckEmail = "SELECT COUNT(*) FROM NguoiDung WHERE Email = ? AND TenNguoiDung != ?";
    $stmtCheckEmail = $conn->prepare($sqlCheckEmail);
    $stmtCheckEmail->bind_param("ss", $email, $tenNguoiDung); // Gắn tham số vào câu lệnh SQL
    $stmtCheckEmail->execute();
    $stmtCheckEmail->bind_result($count); // Lấy kết quả vào biến $count
    $stmtCheckEmail->fetch(); // Truy vấn và gán giá trị vào $count
    $stmtCheckEmail->close();

    return $count > 0; // Nếu count > 0 thì có trùng, ngược lại thì không trùng
}

// Hàm kiểm tra trùng lặp số điện thoại
function checkDuplicatePhone($soDienThoai, $tenNguoiDung, $conn) {
    // Câu lệnh SQL kiểm tra số điện thoại
    $sqlCheckPhone = "SELECT COUNT(*) FROM NguoiDung WHERE SoDienThoai = ? AND TenNguoiDung != ?";
    $stmtCheckPhone = $conn->prepare($sqlCheckPhone);
    $stmtCheckPhone->bind_param("ss", $soDienThoai, $tenNguoiDung); // Gắn tham số vào câu lệnh SQL
    $stmtCheckPhone->execute();
    $stmtCheckPhone->bind_result($count); // Lấy kết quả vào biến $count
    $stmtCheckPhone->fetch(); // Truy vấn và gán giá trị vào $count
    $stmtCheckPhone->close();

    return $count > 0; // Nếu count > 0 thì có trùng, ngược lại thì không trùng
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
    // Nếu email đã tồn tại, thông báo lỗi và yêu cầu nhập lại
    echo "Email này đã được sử dụng. Vui lòng nhập lại email khác.";
    exit; // Dừng thực hiện cập nhật
}

// Kiểm tra nếu số điện thoại đã tồn tại trong cơ sở dữ liệu
if (checkDuplicatePhone($soDienThoai, $tenNguoiDung, $conn)) {
    // Nếu số điện thoại đã tồn tại, thông báo lỗi và yêu cầu nhập lại
    echo "Số điện thoại này đã được sử dụng. Vui lòng nhập lại số điện thoại khác.";
    exit; // Dừng thực hiện cập nhật
}

// Tiến hành cập nhật thông tin người dùng nếu email và số điện thoại hợp lệ
if ($tinhTrang === 'Khóa') {
    // Chỉ cập nhật tình trạng
    $sql = "UPDATE NguoiDung SET TinhTrang = ? WHERE TenNguoiDung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tinhTrang, $tenNguoiDung);
} else {
    // Nếu không bị khóa, cho phép thay đổi thông tin
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

// Thực thi câu lệnh
if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật người dùng: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
