<?php
require './db/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu các trường tồn tại trong $_POST
    $TenNguoiDung = isset($_POST['TenNguoiDung']) ? $_POST['TenNguoiDung'] : '';
    $hoVaTen = isset($_POST['HoTen']) ? $_POST['HoTen'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : ''; 
    $tinh = isset($_POST['tinh']) ? $_POST['tinh'] : '';
    $huyen = isset($_POST['huyen']) ? $_POST['huyen'] : '';
    $xa = isset($_POST['xa']) ? $_POST['xa'] : '';
    $diaChiCuThe = isset($_POST['diaChi']) ? $_POST['diaChi'] : '';
    $soDienThoai = isset($_POST['soDienThoai']) ? $_POST['soDienThoai'] : '';
    $vaiTro = isset($_POST['vaiTro']) ? $_POST['vaiTro'] : '';
    $matKhau = isset($_POST['matKhau']) ? $_POST['matKhau'] : '';
    $nhapLaiMatKhau = isset($_POST['nhapLaiMatKhau']) ? $_POST['nhapLaiMatKhau'] : '';

    // Kiểm tra xem mật khẩu và nhập lại mật khẩu có khớp không
    if ($matKhau !== $nhapLaiMatKhau) {
        echo "<script>
            alert('Mật khẩu nhập lại không khớp!');
            window.location.href = 'themnguoidung.php';    
        </script>";
        exit;
    }

    // Mã hóa mật khẩu trước khi lưu
    $hashed_password = password_hash($matKhau, PASSWORD_BCRYPT);

    // Chèn dữ liệu vào bảng NguoiDung
    $query = "INSERT INTO NguoiDung (TenNguoiDung, HoTen, Email, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, SoDienThoai, VaiTro, MatKhau) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($query);

    // Liên kết các tham số
    $stmt->bind_param("ssssssssss", $TenNguoiDung, $hoVaTen, $email, $tinh, $huyen, $xa, $diaChiCuThe, $soDienThoai, $vaiTro, $hashed_password);

    // Kiểm tra và thực thi câu lệnh
    if ($stmt->execute()) {
        echo "<script>
            alert('Đăng ký thành công!');
            window.location.href = 'danhsachnguoidung.php'    
        </script>";
    } else {
        echo "Lỗi khi đăng ký!";
    }

    // Đóng kết nối
    $stmt->close();
}
?>
