    <?php
    require('./db/connect.php');
    require('includes/header.php');

    if (isset($_GET['mahoadon'])) {
        $maHD = mysqli_real_escape_string($conn, $_GET['mahoadon']);

        // Fetch order information
        $sql = "SELECT * FROM HoaDon WHERE MaHoaDon='$maHD'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
    
            } else {
                echo "Không tìm thấy hóa đơn.";
                exit;
            }
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
            exit;
        }
        
        // Fetch order details
        $sql_ct = "SELECT cthd.*, sp.TenSanPham 
                FROM ChiTietHoaDon cthd 
                JOIN SanPham sp ON cthd.MaSanPham = sp.MaSanPham 
                WHERE cthd.MaHoaDon = ?";
        $stmt_ct = $conn->prepare($sql_ct);
        $stmt_ct->bind_param("s", $maHD);
        $stmt_ct->execute();
        $result_ct = $stmt_ct->get_result();

        $chiTietSanPham = ($result_ct->num_rows > 0) ? $result_ct->fetch_all(MYSQLI_ASSOC) : [];
    } else {
        echo "Mã hóa đơn không hợp lệ.";
        exit;
    }
    ?>


        <style>
            .invoice-box {
                background: #fff;
                padding: 30px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0,0,0,.15);
                font-size: 16px;
                line-height: 24px;
                color: #555;
            }
            .invoice-box h1 {
                font-size: 28px;
                margin-bottom: 20px;
                text-align: center;
                font-weight: bold;
            }
            .top-section {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }
            .top-section div {
                width: 48%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            table th, table td {
                padding: 8px;
                border: 1px solid #ccc;
            }
            .totals {
                text-align: right;
                font-weight: bold;
            }
        </style>

    <div class="container mt-5">
    <h2 class="text-center mb-4">Chi tiết đơn hàng - <?= htmlspecialchars($row['MaHoaDon']) ?></h2>
        
    <div class="invoice-box">
        <h1>HÓA ĐƠN</h1>

        <div class="top-section">
            <div class="billed-to">
                <strong>Họ tên người nhận :</strong> <?= htmlspecialchars($row['NguoiNhanHang']) ?><br>
                <strong>Số điện thoại : </strong><?= htmlspecialchars($row['SoDienThoai']) ?><br>
                <strong>Email : </strong><?= htmlspecialchars($row['Email']) ?><br>
                <strong>Địa chỉ : </strong><?= "{$row['DiaChiCuThe']}, {$row['PhuongXa']}, {$row['QuanHuyen']}, {$row['TPTinh']}" ?>
            </div>
            <div class="invoice-info">
    <strong>Mã hóa đơn:</strong> <?= htmlspecialchars($row['MaHoaDon']) ?><br>
                <strong>Ngày giờ:</strong> <?= htmlspecialchars($row['NgayGio']) ?><br>
                <strong>Thanh toán:</strong> <?= htmlspecialchars($row['HinhThucThanhToan']) ?><br>
                <?php
                    switch ($row['TrangThai']) {
                        case 'Chưa xác nhận':
                            $statusClass = 'bg-secondary text-white';
                            break;
                        case 'Đã xác nhận':
                            $statusClass = 'bg-info text-white';
                            break;
                        case 'Đã giao thành công':
                            $statusClass = 'bg-success text-white';
                            break;
                        case 'Đã hủy':
                            $statusClass = 'bg-danger text-white';
                            break;
                        default:
                            $statusClass = 'bg-light text-dark';
                            break;
                    }
                ?>
                <strong>Trạng thái:</strong> 
                <span class="badge <?= $statusClass ?>" style="padding: 5px 10px; border-radius: 5px;">
                    <?= htmlspecialchars($row['TrangThai']) ?>
                </span>
            </div>
        </div>

        <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th style="text-align: center;">SL</th>
                <th style="text-align: right;">Đơn giá</th>
                <th style="text-align: right;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chiTietSanPham as $sp): ?>
                <tr>
                    <td><?= htmlspecialchars($sp['TenSanPham']) ?></td>
                    <td style="text-align: center;"><?= $sp['SoLuong'] ?></td>
                    <td style="text-align: right;">
                        <?= number_format($sp['DonGia'], 0, ',', '.') ?>đ
                    </td>
                    <td style="text-align: right;">
                        <?php 
                            // Tính thành tiền
                            $thanhTien = $sp['SoLuong'] * $sp['DonGia'];
                            echo number_format($thanhTien, 0, ',', '.') . 'đ';
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        Tổng cộng: 
        <?php 
            // Tính tổng tiền
            $tongTien = $row['TongTien']; 
            echo number_format($tongTien, 0, ',', '.') . 'đ'; 
        ?>
    </div>

    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php require('includes/footer.php'); ?>  
