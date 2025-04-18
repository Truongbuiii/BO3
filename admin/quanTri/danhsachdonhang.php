<?php
require('includes/header.php');
require("./db/connect.php");

// Khởi tạo các biến mặc định cho việc lọc
$startDate = isset($_GET['start-date']) ? $_GET['start-date'] : '';
$endDate = isset($_GET['end-date']) ? $_GET['end-date'] : '';
$tinhTrang = isset($_GET['tinhtrang']) ? $_GET['tinhtrang'] : '';
$tinh = isset($_GET['tinh']) ? $_GET['tinh'] : '';
$quan = isset($_GET['quan']) ? $_GET['quan'] : '';
$phuong = isset($_GET['phuong']) ? $_GET['phuong'] : '';

// Xây dựng phần WHERE của câu truy vấn SQL
$whereClauses = [];
if ($startDate) {
    $whereClauses[] = "HD.NgayGio >= '$startDate'";
}
if ($endDate) {
    $whereClauses[] = "HD.NgayGio <= '$endDate'";
}
if ($tinhTrang) {
    $whereClauses[] = "HD.TrangThai = '$tinhTrang'";
}
if ($tinh) {
    $whereClauses[] = "HD.TPTinh = '$tinh'";
}
if ($quan) {
    $whereClauses[] = "HD.QuanHuyen = '$quan'";
}
if ($phuong) {
    $whereClauses[] = "HD.PhuongXa = '$phuong'";
}

// Kết hợp các điều kiện trong WHERE
$whereSql = '';
if (count($whereClauses) > 0) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Câu truy vấn SQL hoàn chỉnh
$sql = "SELECT HD.MaHoaDon, HD.TenNguoiDung, HD.NguoiNhanHang, HD.TPTinh, HD.QuanHuyen, HD.PhuongXa, HD.DiaChiCuThe, HD.NgayGio, HD.Email, HD.TongTien, HD.TrangThai, HD.HinhThucThanhToan FROM HoaDon AS HD $whereSql";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn)); // Kiểm tra lỗi truy vấn
}
?>

<div class="container mt-4">
    <h3 class="text-center mb-4">Trang danh sách đơn hàng</h3>

    <!-- Filter Section -->
    <div class="filter-form mb-4">
        <form action="danhsachdonhang.php" method="GET" class="d-flex justify-content-between">
            <div class="d-flex">
                <div class="filter">
                    <label for="start-date">Từ ngày:</label>
                    <input type="date" id="start-date" name="start-date" class="form-control mr-3" value="<?php echo $startDate; ?>">
                </div>
                <div class="filter">
                    <label for="end-date">Đến ngày:</label>
                    <input type="date" id="end-date" name="end-date" class="form-control mr-3" value="<?php echo $endDate; ?>">
                </div>
            </div>
            <div class="filter">
                <label for="tinhtrang">Lọc theo tình trạng:</label>
                <select id="tinhtrang" name="tinhtrang" class="form-control">
                    <option value="" disabled <?php echo !$tinhTrang ? 'selected' : ''; ?>>-- Chọn tình trạng --</option>
                    <option value="Chưa xác nhận" <?php echo $tinhTrang == 'Chưa xác nhận' ? 'selected' : ''; ?>>Chưa xác nhận</option>
                    <option value="Đã xác nhận" <?php echo $tinhTrang == 'Đã xác nhận' ? 'selected' : ''; ?>>Đã xác nhận</option>
                    <option value="Đã giao thành công" <?php echo $tinhTrang == 'Đã giao thành công' ? 'selected' : ''; ?>>Đã giao thành công</option>
                    <option value="Đã huỷ" <?php echo $tinhTrang == 'Đã huỷ' ? 'selected' : ''; ?>>Đã huỷ</option>
                </select>
            </div>

            <!-- Thành phố, Quận, Phường -->
            <div class="filter">
                <label for="tinh">Thành phố:</label>
                <select id="tinh" name="tinh" class="form-control">
                    <option value="" disabled selected>-- Chọn thành phố --</option>
                    <!-- Thêm các thành phố khác nếu cần -->
                </select>
            </div>

            <div class="filter">
                <label for="quan">Quận/Huyện:</label>
                <select id="quan" name="quan" class="form-control">
                <option value="" disabled selected>-- Chọn quận/huyện --</option>
                <option value="Quận 1">Quận 1</option>
                <option value="Quận 3">Quận 3</option>
                <option value="Quận 5">Quận 5</option>
                <option value="Quận 7">Quận 7</option>
                <option value="Bình Thạnh">Bình Thạnh</option>
                <option value="Gò Vấp">Gò Vấp</option>
                <option value="Tân Bình">Tân Bình</option>
                <option value="Thủ Đức">Thủ Đức</option>
                <option value="Quận 10">Quận 10</option>
                    <!-- Thêm các quận khác nếu cần -->
                </select>
            </div>

            <div class="filter">
                <label for="phuong">Phường/Xã:</label>
                <select id="phuong" name="phuong" class="form-control">
                    <option value="" disabled selected>-- Chọn phường/xã --</option>
                    <!-- Thêm các phường/xã tùy theo quận đã chọn -->
                </select>
            </div>

            <div class="filter-button">
                <button class="btn btn-primary" type="submit">Lọc</button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên Người nhận</th>
                            <th>Email</th>
                            <th>Thành phố/ Tỉnh</th>
                            <th>Quận / Huyện</th>
                            <th>Phường / Xã</th>
                            <th>Địa chỉ cụ thể</th>
                            <th>Ngày giờ</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hình thức thanh toán</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên Người nhận</th>
                            <th>Email</th>
                            <th>Thành phố/ Tỉnh</th>
                            <th>Quận / Huyện</th>
                            <th>Phường / Xã</th>
                            <th>Địa chỉ cụ thể</th>
                            <th>Ngày giờ</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hình thức thanh toán</th>
                            <th>Chức năng</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        if($result && mysqli_num_rows($result) > 0 ){
                            while ($row = mysqli_fetch_assoc($result)){
                                echo "<tr>
                                <td>{$row['MaHoaDon']}</td>
                                <td>{$row['NguoiNhanHang']}</td>
                                <td>{$row['Email']}</td>
                                <td>{$row['TPTinh']}</td>
                                <td>{$row['QuanHuyen']}</td>
                                <td>{$row['PhuongXa']}</td>
                                <td>{$row['DiaChiCuThe']}</td>
                                <td>{$row['NgayGio']}</td>
                                <td>{$row['TongTien']}</td>
                                <td>{$row['TrangThai']}</td>
                                <td>{$row['HinhThucThanhToan']}</td>
                                <td>
                                    <a href='suadonhang.php?mahoadon={$row['MaHoaDon']}' class='btn btn-warning btn-sm'>Sửa</a>
                                </td>
                                </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require('includes/footer.php'); ?>


<!-- JavaScript for Dynamic Dropdowns -->
<script>
  const data = {
      "Quận 1": ["Bến Nghé", "Bến Thành", "Cầu Ông Lãnh", "Cô Giang", "Nguyễn Thái Bình"],
      "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
      "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
      "Quận 7": ["Tân Phong", "Tân Hưng", "Bình Thuận", "Phú Mỹ", "Tân Kiểng", "Tân Quy"],
      "Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 8"],
      "Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8"],
      "Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
      "Thủ Đức": ["Bình Chiểu", "Bình Thọ", "Hiệp Bình Chánh", "Hiệp Phú", "Linh Chiểu", "Linh Đông"],
      "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8"]
  };

  const quanSelect = document.getElementById('quan');
  const phuongSelect = document.getElementById('phuong');

  quanSelect.addEventListener('change', function() {
      const selectedQuan = this.value;
      const phuongs = data[selectedQuan] || [];

      phuongSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';

      phuongs.forEach(phuong => {
          const option = document.createElement('option');
          option.value = phuong;
          option.textContent = phuong;
          phuongSelect.appendChild(option);
      });
  });
</script>

<!-- CSS Giao diện -->
<style>
/* Form Lọc */
.filter-form {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.filter-form .d-flex {
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.filter {
    display: flex;
    flex-direction: column;
    width: 220px;
    margin-bottom: 15px;
}

.filter label {
    font-weight: bold;
    margin-bottom: 5px;
}

.filter select, .filter input {
    height: 38px;
    padding: 6px 12px;
    font-size: 14px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Đảm bảo các trường có chiều rộng đều nhau */
.filter-form .d-flex .filter {
    flex: 1 1 220px; /* Mỗi ô lọc sẽ có chiều rộng tối thiểu là 220px */
    min-width: 220px;  /* Đảm bảo chiều rộng tối thiểu */
}

.filter-form .d-flex .filter input,
.filter-form .d-flex .filter select {
    width: 100%; /* Giúp các trường chiếm toàn bộ không gian của thẻ cha */
}

/* Button Lọc */
.filter-button {
    display: flex;
    justify-content: flex-end;
    margin-top: 15px;
}

.filter-button button {
    padding: 8px 20px;
    font-weight: bold;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.filter-button button:hover {
    background-color: #0056b3;
}

/* Bảng Danh sách Đơn hàng */
.table-responsive {
    margin-top: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow-x: auto; /* Cho phép cuộn ngang nếu bảng quá rộng */
    max-width: 100%;  /* Giới hạn chiều rộng bảng */
}

.table {
    table-layout: fixed; /* Giới hạn chiều rộng của các cột */
    width: 100%;  /* Đảm bảo bảng chiếm hết không gian có sẵn */
}

.table th, .table td {
    text-align: center;
    vertical-align: middle;
    padding: 10px; /* Giảm padding để bảng không quá rộng */
    font-size: 16px; /* Giảm font size cho phù hợp */
}

.table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    border: 1px solid #ddd;
}

.table td {
    background-color: #fff;
    border: 1px solid #ddd;
}

.table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}


/* Chỉnh sửa thêm style cho các phần tử khác */
.card {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #f1f1f1;
    font-weight: bold;
    text-transform: uppercase;
}

.card-body {
    padding: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-form .d-flex {
        flex-direction: column;
    }

    .filter-form .d-flex .filter {
        width: 100%;
    }

    .filter-button {
        justify-content: center;
    }
}

