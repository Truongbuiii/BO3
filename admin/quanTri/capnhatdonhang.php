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
    $htThanhToan = mysqli_real_escape_string($conn, $_POST['HinhThucThanhToan']);
    $trangThaiMoi = mysqli_real_escape_string($conn, $_POST['TrangThai']);

    // Lấy trạng thái hiện tại trong DB
    $trangThaiQuery = "SELECT TrangThai FROM HoaDon WHERE MaHoaDon='$maHD'";
    $trangThaiResult = mysqli_query($conn, $trangThaiQuery);
    $row = mysqli_fetch_assoc($trangThaiResult);
    $trangThaiCu = $row['TrangThai'];

    // Danh sách trạng thái theo thứ tự
    $thuTuTrangThai = [
        "Chưa xác nhận" => 1,
        "Đã xác nhận" => 2,
        "Đã giao thành công" => 3,
        "Đã huỷ" => 99 // Có thể cấu hình riêng nếu muốn giới hạn hủy
    ];

    // Kiểm tra nếu trạng thái mới bị "ngược"
    if ($thuTuTrangThai[$trangThaiMoi] < $thuTuTrangThai[$trangThaiCu]) {
        echo "<script>alert('❌ Không thể cập nhật trạng thái lùi về trước!'); window.history.back();</script>";
        exit;
    }

    // Cập nhật nếu hợp lệ
    $sql = "UPDATE HoaDon SET 
                NguoiNhanHang='$nguoiNhan',
                Email='$email',
                TPTinh='$tpTinh',
                QuanHuyen='$quanHuyen',
                PhuongXa='$phuongXa',
                DiaChiCuThe='$diaChi',
                TrangThai='$trangThaiMoi',
                HinhThucThanhToan='$htThanhToan'
            WHERE MaHoaDon='$maHD'";

    if (mysqli_query($conn, $sql)) {
        header("Location: danhsachdonhang.php");
        exit;
    } else {
        echo "❌ Lỗi cập nhật: " . mysqli_error($conn);
    }
}
?>
