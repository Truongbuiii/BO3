<?php
require('includes/header.php');
require("./db/connect.php");

// Khởi tạo các biến lọc
$startDate = $_GET['start-date'] ?? '';
$endDate = $_GET['end-date'] ?? '';
$tinhTrang = $_GET['tinhtrang'] ?? '';
$tinh = $_GET['tinh'] ?? '';
$quan = $_GET['quan'] ?? '';
$phuong = $_GET['phuong'] ?? '';

// Xây dựng mảng điều kiện lọc và giá trị tương ứng
$whereClauses = [];
$params = [];

if (!empty($startDate)) {
    $whereClauses[] = "HD.NgayGio >= ?";
    $params[] = $startDate;
}
if (!empty($endDate)) {
    $whereClauses[] = "HD.NgayGio <= ?";
    $params[] = $endDate;
}
if (!empty($tinhTrang)) {
    $whereClauses[] = "HD.TrangThai = ?";
    $params[] = $tinhTrang;
}
if (!empty($tinh)) {
    $whereClauses[] = "HD.TPTinh = ?";
    $params[] = $tinh;
}
if (!empty($quan)) {
    $whereClauses[] = "HD.QuanHuyen = ?";
    $params[] = $quan;
}
if (!empty($phuong)) {
    $whereClauses[] = "HD.PhuongXa = ?";
    $params[] = $phuong;
}

// Kết hợp điều kiện WHERE
$whereSql = '';
if (!empty($whereClauses)) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Câu truy vấn
$sql = "SELECT HD.MaHoaDon, HD.TenNguoiDung, HD.NguoiNhanHang, HD.TPTinh, HD.QuanHuyen, HD.PhuongXa, HD.DiaChiCuThe, HD.NgayGio, HD.Email, HD.TongTien, HD.TrangThai, HD.HinhThucThanhToan FROM HoaDon AS HD $whereSql";

// Chuẩn bị truy vấn
$stmt = mysqli_prepare($conn, $sql);

// Gán các giá trị nếu có điều kiện
if (!empty($params)) {
    // Tạo kiểu dữ liệu cho bind_param
    $types = str_repeat('s', count($params)); // tất cả là chuỗi
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Thực thi truy vấn
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
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
                    <option value="Đã  huỷ" <?php echo $tinhTrang == 'Đã huỷ' ? 'selected' : ''; ?>>Đã huỷ</option>
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

         <div class="filter-button d-flex justify-content-start gap-3 mt-3">
    <button class="btn btn-primary btn-lg px-4" type="submit">Lọc</button>
    <a href="danhsachdonhang.php" class="btn btn-danger btn-lg px-4">Hủy lọc</a>
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
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Xác định lớp CSS cho trạng thái dựa trên giá trị của nó
                $statusClass = '';
                switch ($row['TrangThai']) {
                    case 'Chưa xác nhận':
                        $statusClass = 'bg-secondary white'; // Màu xám nhạt
                        break;
                    case 'Đã xác nhận':
                        $statusClass = 'bg-info text-white'; // Màu xanh dương
                        break;
                    case 'Đã giao thành công':
                        $statusClass = 'bg-success text-white'; // Màu xanh lá
                        break;
                    case 'Đã hủy':
                        $statusClass = 'bg-danger text-white'; // Màu đỏ
                        break;
                    default:
                        $statusClass = 'bg-light text-dark'; // Màu mặc định nếu trạng thái không xác định
                        break;
                }

                // In ra hàng với màu sắc trạng thái động
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
    <td><span class='badge {$statusClass}'>{$row['TrangThai']}</span></td>
    <td>{$row['HinhThucThanhToan']}</td>
    <td>
        <a href='suadonhang.php?mahoadon={$row['MaHoaDon']}' class='btn btn-warning btn-sm mb-1'>
            <i class='fa fa-edit'></i> Sửa
        </a>
        <a href='chitiethoadon.php?MaHoaDon={$row['MaHoaDon']}' class='btn btn-info btn-sm'>
            <i class='fa fa-eye'></i> Xem
        </a>
    </td>
</tr>";
;
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

/* Nút Lọc & Hủy lọc */
.filter-button .btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 10px 28px;
    font-size: 16px;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
}

.filter-button .btn-primary {
    background: linear-gradient(135deg, #007bff, #3399ff);
    border: none;
    color: white;
}

.filter-button .btn-primary:hover {
    background: linear-gradient(135deg, #0069d9, #2288ff);
    transform: translateY(-1px);
}

.filter-button .btn-danger {
    background: #e74c3c;
    border: none;
    color: white;
    box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
}

.filter-button .btn-danger:hover {
    background: #c0392b;
    transform: translateY(-1px);
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
/* Chỉnh sửa badge trong trạng thái */
.badge {
    display: inline-block;
    padding: 4px 8px;
    font-size: 0.85rem;
    border-radius: 12px;
    max-width: 100%;
    word-wrap: break-word; /* Cho phép chữ xuống dòng khi cần */
    white-space: normal;  /* Cho phép xuống dòng */
}

/* Đảm bảo phần trạng thái không bị tràn cột và xuống dòng khi cần */
.table td.trangthai-cell {
    max-width: 150px;  /* Giới hạn chiều rộng cột trạng thái */
    word-wrap: break-word;  /* Cho phép chữ xuống dòng */
    white-space: normal;  /* Cho phép xuống dòng */
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

