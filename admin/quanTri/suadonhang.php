<?php
require('./db/connect.php');
require('includes/header.php');

if (isset($_GET['mahoadon'])) {
    $maHD = mysqli_real_escape_string($conn, $_GET['mahoadon']);
    // Truy vấn thông tin đơn hàng từ cơ sở dữ liệu
    $sql = "SELECT * FROM HoaDon WHERE MaHoaDon='$maHD'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Lấy thông tin đơn hàng vào biến $row
    } else {
        echo "<div class='alert alert-danger'>❌ Không tìm thấy đơn hàng với mã hóa đơn: $maHD.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>❌ Thiếu mã hóa đơn.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h3>Chỉnh sửa thông tin đơn hàng</h3>
    <form method="POST" action="capnhatdonhang.php">
        <input type="hidden" name="MaHoaDon" value="<?php echo $row['MaHoaDon']; ?>">

        <div class="form-group">
            <label>Người nhận hàng</label>
            <input type="text" name="NguoiNhanHang" class="form-control" value="<?php echo $row['NguoiNhanHang']; ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="Email" class="form-control" value="<?php echo $row['Email']; ?>" required>
        </div>

        <div class="form-group">
            <label>Thành phố/Tỉnh</label>
            <select name="TPTinh" id="city" class="form-control" required>
                <option value="TP Hồ Chí Minh" <?php if($row['TPTinh'] == 'TP Hồ Chí Minh') echo 'selected'; ?>>TP Hồ Chí Minh</option>
            </select>
        </div>

        <div class="form-group">
            <label>Quận/Huyện</label>
            <select name="QuanHuyen" id="district" class="form-control" required>
                <option value="<?php echo $row['QuanHuyen']; ?>"><?php echo $row['QuanHuyen']; ?></option>
            </select>
        </div>

        <div class="form-group">
            <label>Phường/Xã</label>
            <select name="PhuongXa" id="ward" class="form-control" required>
                <option value="<?php echo $row['PhuongXa']; ?>"><?php echo $row['PhuongXa']; ?></option>
            </select>
        </div>

        <div class="form-group">
            <label>Địa chỉ cụ thể</label>
            <input type="text" name="DiaChiCuThe" class="form-control" value="<?php echo $row['DiaChiCuThe']; ?>">
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <select name="TrangThai" class="form-control">
                <option value="Chưa xác nhận" <?php if(trim($row['TrangThai']) === 'Chưa xác nhận') echo 'selected'; ?>>Chưa xác nhận</option>
                <option value="Đã xác nhận" <?php if($row['TrangThai']=='Đã xác nhận') echo 'selected'; ?>>Đã xác nhận</option>
                <option value="Đã giao thành công" <?php if($row['TrangThai']=='Đã giao thành công') echo 'selected'; ?>>Đã giao thành công</option>
                <option value="Đã huỷ" <?php if($row['TrangThai']=='Đã huỷ') echo 'selected'; ?>>Đã huỷ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Hình thức thanh toán</label>
            <select name="HinhThucThanhToan" class="form-control">
                <option value="Tiền mặt" <?php if($row['HinhThucThanhToan']=='Tiền mặt') echo 'selected'; ?>>Tiền mặt</option>
                <option value="Chuyển khoản" <?php if($row['HinhThucThanhToan']=='Chuyển khoản') echo 'selected'; ?>>Chuyển khoản</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="danhsachdonhang.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
const data = {
    "TP Hồ Chí Minh": {
       "Quận 1": ["Phường Cầu Kho","Phường Bến Nghé", "Phường Bến Thành", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Nguyễn Thái Bình"],
        "Quận 2":["Phường An Phú","Phường Tân Bình","Phường Tân Phú"],
        "Quận 3": ["Phường Võ Thị Sáu", "Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7","Phường 14"],
        "Quận 4":["Phường 10","Phường 11","Phường 12","Phường 13"],
        "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 8"],
        "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10"],
        "Quận 7": ["Phường Tân Thuận Tây","Phường Tân Phong", "Phường Tân Hưng", "Phường Bình Thuận", "Phường Phú Mỹ", "Phường Tân Kiểng", "Phường Tân Quy", "Phường Tân Phú"],
        "Quận 8":["Phường 11","Phường 15"],
        "Quận 9":["Phường Hiệp Phú","Phường Hiệp Bình Chánh","Phường Long Trường"],
        "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8","Phường 9"],
        "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 16", "Phường 7"],
        "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 25", "Phường 6", "Phường 7", "Phường 8"],
        "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
        "Thành phố Thủ Đức": ["Phường Bình Chiểu", "Phường Bình Thọ", "Phường Hiệp Bình Chánh", "Phường Hiệp Phú", "Phường Linh Trung", "Phường Linh Đông"],
        "Quận Bình Tân": ["Phường Bình Hưng Hòa", "Phường Bình Trị Đông", "Phường Tân Tạo", "Phường An Lạc", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B"],
        "Huyện Nhà Bè": ["Xã Phước Kiển", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức"],
        "Quận Phú Nhuận":["Phường 9"]
    }
};

const districtSelect = document.getElementById('district');
const wardSelect = document.getElementById('ward');
const citySelect = document.getElementById('city');

// Cập nhật Quận/Huyện khi thay Thành phố
citySelect.addEventListener('change', function () {
    const selectedCity = this.value;
    const districts = data[selectedCity];

    districtSelect.innerHTML = '';
    wardSelect.innerHTML = '';

    for (const district in districts) {
        const option = document.createElement('option');
        option.value = district;
        option.text = district;
        districtSelect.appendChild(option);
    }

    districtSelect.dispatchEvent(new Event('change'));
});

// Cập nhật Phường/Xã khi thay Quận/Huyện
districtSelect.addEventListener('change', function () {
    const selectedCity = citySelect.value;
    const selectedDistrict = this.value;
    const wards = data[selectedCity][selectedDistrict];

    wardSelect.innerHTML = '';

    for (const ward of wards) {
        const option = document.createElement('option');
        option.value = ward;
        option.text = ward;
        wardSelect.appendChild(option);
    }
});

// Tự động set giá trị ban đầu khi load form
window.addEventListener('DOMContentLoaded', () => {
    const currentDistrict = "<?php echo $row['QuanHuyen']; ?>";
    const currentWard = "<?php echo $row['PhuongXa']; ?>";

    citySelect.dispatchEvent(new Event('change'));

    if (currentDistrict) {
        districtSelect.value = currentDistrict;
        districtSelect.dispatchEvent(new Event('change'));
    }

    if (currentWard) {
        wardSelect.value = currentWard;
    }
});
</script>

<?php require('includes/footer.php'); ?>
