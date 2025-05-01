<?php
require('./db/connect.php');

// Kiểm tra nếu có mã hóa đơn trên URL
if (isset($_GET['MaHoaDon'])) {
    $maHD = mysqli_real_escape_string($conn, $_GET['MaHoaDon']);

    $sql = "SELECT * FROM HoaDon WHERE MaHoaDon='$maHD'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>❌ Không tìm thấy đơn hàng với mã $maHD.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>❌ Thiếu mã hóa đơn.</div>";
    exit;
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maHD = mysqli_real_escape_string($conn, $_POST['MaHoaDon']);
    $nguoiNhan = mysqli_real_escape_string($conn, $_POST['NguoiNhanHang']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $tpTinh = mysqli_real_escape_string($conn, $_POST['TPTinh']);
    $quanHuyen = mysqli_real_escape_string($conn, $_POST['QuanHuyen']);
    $phuongXa = mysqli_real_escape_string($conn, $_POST['PhuongXa']);
    $diaChi = mysqli_real_escape_string($conn, $_POST['DiaChiCuThe']);
    $htThanhToan = mysqli_real_escape_string($conn, $_POST['HinhThucThanhToan']);
    $trangThaiMoi = trim(mysqli_real_escape_string($conn, $_POST['TrangThai']));

    // Lấy trạng thái hiện tại trong DB
    $trangThaiQuery = "SELECT TrangThai FROM HoaDon WHERE MaHoaDon='$maHD'";
    $trangThaiResult = mysqli_query($conn, $trangThaiQuery);

    if ($trangThaiResult && $row = mysqli_fetch_assoc($trangThaiResult)) {
        $trangThaiCu = trim($row['TrangThai']);

        // Danh sách thứ tự trạng thái
        $thuTuTrangThai = [
            "Chưa xác nhận" => 1,
            "Đã xác nhận" => 2,
            "Đã giao thành công" => 3,
            "Đã huỷ" => 4
        ];

        $thuTuCu = $thuTuTrangThai[$trangThaiCu] ?? 0;
        $thuTuMoi = $thuTuTrangThai[$trangThaiMoi] ?? 0;

        if ($thuTuMoi < $thuTuCu) {
            // Trở lại trang sửa đơn với cảnh báo
            header("Location: suadonhang.php?MaHoaDon=$maHD&error=reverse");
            exit;
        }

        // Thực hiện cập nhật
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
    } else {
        echo "❌ Không tìm thấy hóa đơn.";
    }
}
?>
