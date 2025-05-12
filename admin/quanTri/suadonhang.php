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
    <div class="card shadow mb-4" style="border: 1px solid #ddd; padding: 20px;">
    <form method="POST" action="capnhatdonhang.php">
        <input type="hidden" name="MaHoaDon" value="<?php echo $row['MaHoaDon']; ?>">

        <div class="form-group">
            <label>Mã đơn hàng</label>
            <input type="text" class="form-control" value="<?php echo $row['MaHoaDon']; ?>" disabled>
        </div>

        <div class="form-group">
            <label>Người nhận hàng</label>
            <input type="text" name="NguoiNhanHang" class="form-control" value="<?php echo $row['NguoiNhanHang']; ?>" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="SoDienThoai" class="form-control" value="<?php echo $row['SoDienThoai']; ?>" required>
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

        <div class="d-flex justify-content-between">
    <button type="submit" class="btn btn-secondary btn-lg btn-save">Lưu thay đổi</button>
    <a href="danhsachdonhang.php" class="btn btn-secondary btn-lg btn-cancel">Quay lại</a>
</div>
<style> .btn-save {
            background-color: #28a745; /* Xanh lá */
            color: white;
            border: none;
        }

        .btn-save:hover {
            background-color: #218838;
        }

        .btn-cancel {
            background-color: #dc3545; /* Đỏ */
            color: white;
            border: none;
        }

        .btn-cancel:hover {
            background-color: #c82333;
        }</style>
    </form>
</div>

</div>

<script>
const data = {
    "TP Hồ Chí Minh": {
        "Quận 1": ["Phường Tân Định", "Phường Đa Kao", "Phường Bến Nghé", "Phường Bến Thành", "Phường Nguyễn Thái Bình", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Nguyễn Cư Trinh", "Phường Phạm Ngũ Lão", "Phường Cầu Kho"],
    "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường Võ Thị Sáu"],
    "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 6", "Phường 8", "Phường 9", "Phường 10", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 18"],
    "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
    "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
    "Quận 7": ["Phường Tân Thuận Đông", "Phường Tân Thuận Tây", "Phường Tân Kiểng", "Phường Tân Hưng", "Phường Tân Phong", "Phường Tân Phú", "Phường Phú Mỹ", "Phường Phú Thuận", "Phường Bình Thuận", "Phường Tân Quy"],
    "Quận 8": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
    "Quận 10": ["Phường 1", "Phường 2", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
    "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
    "Quận 12": ["Phường An Phú Đông", "Phường Đông Hưng Thuận", "Phường Hiệp Thành", "Phường Tân Chánh Hiệp", "Phường Tân Hưng Thuận", "Phường Tân Thới Hiệp", "Phường Tân Thới Nhất", "Phường Thạnh Lộc", "Phường Thạnh Xuân", "Phường Thới An", "Phường Trung Mỹ Tây"],
    "Quận Bình Tân": ["Phường An Lạc", "Phường An Lạc A", "Phường Bình Hưng Hòa", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B", "Phường Bình Trị Đông", "Phường Bình Trị Đông A", "Phường Bình Trị Đông B", "Phường Tân Tạo", "Phường Tân Tạo A"],
    "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"],
    "Quận Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 17"],
    "Quận Phú Nhuận": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 13", "Phường 15", "Phường 17"],
    "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
    "Quận Tân Phú": ["Phường Hiệp Tân", "Phường Hòa Thạnh", "Phường Phú Thạnh", "Phường Phú Thọ Hòa", "Phường Phú Trung", "Phường Sơn Kỳ", "Phường Tân Quý", "Phường Tân Sơn Nhì", "Phường Tân Thành", "Phường Tây Thạnh"],
    "Thành phố Thủ Đức": ["Phường Hiệp Bình Chánh", "Phường Hiệp Bình Phước", "Phường Linh Chiểu", "Phường Linh Đông", "Phường Linh Tây", "Phường Linh Trung", "Phường Linh Xuân", "Phường Bình Chiểu", "Phường Bình Thọ", "Phường Tam Bình", "Phường Tam Phú", "Phường Trường Thọ", "Phường Bình An", "Phường Bình Trưng Đông", "Phường Bình Trưng Tây", "Phường Cát Lái", "Phường Thảo Điền", "Phường An Khánh", "Phường An Phú", "Phường Phước Long A", "Phường Phước Long B", "Phường Tăng Nhơn Phú A", "Phường Tăng Nhơn Phú B", "Phường Phước Bình", "Phường Tân Phú", "Phường Trường Thạnh", "Phường Long Thạnh Mỹ", "Phường Long Phước", "Phường Long Trường", "Phường Phú Hữu", "Phường Thạnh Mỹ Lợi", "Phường Thủ Thiêm"],
    "Huyện Nhà Bè": ["Xã Phước Kiển", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức"],
    "Quận Phú Nhuận": ["Phường 9"]
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
