<?php
require('includes/header.php');
require('./db/connect.php');

if (isset($_GET['mahoadon'])) {
    $maHD = $_GET['mahoadon'];
    $sql = "SELECT * FROM HoaDon WHERE MaHoaDon = '$maHD'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
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
                <option value="Tiền mặt" <?php if($row['HinhThucThanhToan']=='cod') echo 'selected'; ?>>Tiền mặt</option>
                <option value="Chuyển khoản" <?php if($row['HinhThucThanhToan']=='bank') echo 'selected'; ?>>Chuyển khoản </option>
              
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="danhsachdonhang.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
const data = {
    "TP Hồ Chí Minh": {
        "Quận 1": ["Bến Nghé", "Bến Thành", "Cầu Ông Lãnh", "Cô Giang", "Nguyễn Thái Bình"],
        "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
        "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
        "Quận 7": ["Tân Phong", "Tân Hưng", "Bình Thuận", "Phú Mỹ", "Tân Kiểng", "Tân Quy"],
        "Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 8"],
        "Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8"],
        "Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
        "Thủ Đức": ["Bình Chiểu", "Bình Thọ", "Hiệp Bình Chánh", "Hiệp Phú", "Linh Chiểu", "Linh Đông"],
        "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8"]
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
