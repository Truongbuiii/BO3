<?php
require('./db/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maHD = mysqli_real_escape_string($conn, $_POST['MaHoaDon']);
    $nguoiNhan = mysqli_real_escape_string($conn, $_POST['NguoiNhanHang']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $tpTinh = mysqli_real_escape_string($conn, $_POST['TPTinh']);
    $quanHuyen = mysqli_real_escape_string($conn, $_POST['QuanHuyen']);
    $phuongXa = mysqli_real_escape_string($conn, $_POST['PhuongXa']);
    $diaChi = mysqli_real_escape_string($conn, $_POST['DiaChiCuThe']);
    $trangThai = mysqli_real_escape_string($conn, $_POST['TrangThai']);
    $htThanhToan = mysqli_real_escape_string($conn, $_POST['HinhThucThanhToan']);

    $sql = "UPDATE HoaDon SET 
                NguoiNhanHang='$nguoiNhan',
                Email='$email',
                TPTinh='$tpTinh',
                QuanHuyen='$quanHuyen',
                PhuongXa='$phuongXa',
                DiaChiCuThe='$diaChi',
                TrangThai='$trangThai',
                HinhThucThanhToan='$htThanhToan'
            WHERE MaHoaDon='$maHD'";

    if (mysqli_query($conn, $sql)) {
        header("Location: danhsachdonhang.php"); // quay về danh sách sau khi cập nhật
        exit;
    } else {
        echo "❌ Lỗi cập nhật: " . mysqli_error($conn);
    }
}
?>
