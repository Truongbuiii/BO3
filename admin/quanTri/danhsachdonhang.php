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

$types = '';
$whereClauses = [];
$params = [];

// Xử lý điều kiện lọc
if (!empty($startDate)) {
    $whereClauses[] = "HD.NgayGio >= ?";
    $params[] = $startDate;
    $types .= 's';
}
if (!empty($endDate)) {
    $whereClauses[] = "HD.NgayGio <= ?";
    $params[] = $endDate;
    $types .= 's';
}
if (!empty($tinhTrang)) {
    $whereClauses[] = "HD.TrangThai = ?";
    $params[] = $tinhTrang;
    $types .= 's';
}
if (!empty($tinh)) {
    $whereClauses[] = "HD.TPTinh = ?";
    $params[] = $tinh;
    $types .= 's';
}
if (!empty($quan)) {
    $whereClauses[] = "HD.QuanHuyen = ?";
    $params[] = $quan;
    $types .= 's';
}
if (!empty($phuong)) {
    $whereClauses[] = "HD.PhuongXa = ?";
    $params[] = $phuong;
    $types .= 's';
}

// Phân trang
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Truy vấn chính
$whereSql = '';
if (!empty($whereClauses)) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}
$sql = "SELECT HD.MaHoaDon, HD.TenNguoiDung, HD.NguoiNhanHang,HD.SoDienThoai ,HD.TPTinh, HD.QuanHuyen, HD.PhuongXa, HD.DiaChiCuThe, HD.NgayGio, HD.Email, HD.TongTien, HD.TrangThai, HD.HinhThucThanhToan FROM HoaDon AS HD $whereSql LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= 'ii';

// Chuẩn bị truy vấn
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

// Truy vấn đếm tổng số bản ghi (cho phân trang)
$countSql = "SELECT COUNT(*) AS total FROM HoaDon AS HD $whereSql";
$countStmt = mysqli_prepare($conn, $countSql);
if (!empty($whereClauses)) {
    // Sử dụng lại params ban đầu (trừ 2 phần tử LIMIT, OFFSET)
    $countParams = array_slice($params, 0, -2);
    $countTypes = substr($types, 0, -2);
    mysqli_stmt_bind_param($countStmt, $countTypes, ...$countParams);
}
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);
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
        <option value="">-- Chọn quận/huyện --</option>
        <option value="Quận 1">Quận 1</option>
        <option value="Quận 2">Quận 2</option>   
        <option value="Quận 3">Quận 3</option>
        <option value="Quận 4">Quận 4</option>
        <option value="Quận 5">Quận 5</option>
        <option value="Quận 6">Quận 6</option>
        <option value="Quận 7">Quận 7</option>
        <option value="Quận 8">Quận 8</option>
        <option value="Quận 9">Quận 9</option>
        <option value="Quận 10">Quận 10</option>
        <option value="Quận 11">Quận 11</option>
        <option value="Quận Bình Thạnh">Bình Thạnh</option>
        <option value="Quận Phú Nhuận">Phú Nhuận</option>
        <option value="Quận Tân Bình">Tân Bình</option>
        <option value="Quận Bình Tân">Bình Tân</option>
        <option value="Thành phố Thủ Đức">Thủ Đức</option>
        <option value="Huyện Nhà Bè">Huyện Nhà Bè</option>
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
                        <th>Số điện thoại</th>
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
                        <th>Số điện thoại</th>
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
                                <td>{$row['SoDienThoai']}</td>
                                <td>{$row['QuanHuyen']}</td>
                                <td>{$row['PhuongXa']}</td>
                                <td>{$row['DiaChiCuThe']}</td>
                                <td>{$row['NgayGio']}</td>
                                <td>" . number_format($row['TongTien'], 0, ',', '.') . " VND</td>
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
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php if ($totalPages > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

</div>

<?php require('includes/footer.php'); ?>


<!-- JavaScript for Dynamic Dropdowns -->
<script>
const data = {
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
};

document.getElementById('quan').addEventListener('change', function() {
        const selectedQuan = this.value;
        const phuongs = data[selectedQuan] || [];

        const phuongSelect = document.getElementById('phuong');
        phuongSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>'; // Xóa các phường cũ

        phuongs.forEach(phuong => {
            const option = document.createElement('option');
            option.value = phuong;
            option.textContent = phuong;
            phuongSelect.appendChild(option);
        });
    });

function editUser(TenNguoiDung, HoTen, Email, MatKhau, SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe) {
    document.getElementById('editTenNguoiDung').value = TenNguoiDung;
    document.getElementById('editHoTen').value = HoTen;
    document.getElementById('editEmail').value = Email;
    document.getElementById('editMatKhau').value = MatKhau;
    document.getElementById('editSoDienThoai').value = SoDienThoai;
    document.getElementById('editVaiTro').value = VaiTro;
    document.getElementById('editTinhTrang').value = TinhTrang;
    document.getElementById('editTPTinh').value = TPTinh;
    document.getElementById('editQuanHuyen').value = QuanHuyen;

    // Cập nhật danh sách phường theo quận
    const phuongs = data[QuanHuyen] || [];
    const phuongSelect = document.getElementById('editPhuongXa');
    phuongSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
    phuongs.forEach(phuong => {
        const option = document.createElement('option');
        option.value = phuong;
        option.textContent = phuong;
        phuongSelect.appendChild(option);
    });

    // Sau khi đã render xong danh sách phường thì set value cho Phường/Xã
    document.getElementById('editPhuongXa').value = PhuongXa;

    // Set địa chỉ cụ thể
    document.getElementById('editDiaChiCuThe').value = DiaChiCuThe;

    // Mở popup
    const myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    myModal.show();
}

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

