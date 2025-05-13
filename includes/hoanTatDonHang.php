<?php
session_start();
require(__DIR__ . "/../db/connect.php");

// Kiểm tra mã hóa đơn nhận được từ GET
if (isset($_GET['maHoaDon']) && !empty($_GET['maHoaDon'])) {
    $maHoaDon = filter_var($_GET['maHoaDon']); // Làm sạch mã hóa đơn
    error_log("Mã hóa đơn nhận được: " . $maHoaDon);
} else {
    error_log("Không nhận được mã hóa đơn từ GET");
    echo "<script>
        alert('Mã hóa đơn không hợp lệ'); 
        window.location.href='/index.php';
    </script>";
    exit;
}

// Lấy thông tin hóa đơn từ CSDL
$sql = "SELECT * FROM HoaDon WHERE MaHoaDon = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maHoaDon);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu không tìm thấy hóa đơn
if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    echo "Không tìm thấy đơn hàng!";
    exit;
}

// Truy vấn chi tiết sản phẩm trong đơn hàng từ bảng ChiTietHoaDon
$sql_ct = "SELECT cthd.SoLuong, cthd.DonGia, sp.TenSanPham 
           FROM ChiTietHoaDon cthd 
           JOIN SanPham sp ON cthd.MaSanPham = sp.MaSanPham 
           WHERE cthd.MaHoaDon = ?";

$stmt_ct = $conn->prepare($sql_ct);
$stmt_ct->bind_param("s", $maHoaDon);
$stmt_ct->execute();
$result_ct = $stmt_ct->get_result();

// Kiểm tra xem có chi tiết hóa đơn không
if ($result_ct->num_rows > 0) {
    // Lưu thông tin sản phẩm vào mảng
    $order_details = [];
    $total_product_price = 0; // Khai báo biến tổng tiền sản phẩm
    while ($item = $result_ct->fetch_assoc()) {
        $order_details[] = $item;
        $total_product_price += $item['SoLuong'] * $item['DonGia']; // Tính tổng tiền sản phẩm
    }
} else {
    echo "Không có sản phẩm trong hóa đơn!";
    exit;
}

// Tính phí ship (phí ship = Tổng tiền của đơn hàng - Tổng giá sản phẩm)
$shipping_fee = $order['TongTien'] - $total_product_price; 
$shipping_fee_per_item = $shipping_fee / count($order_details); // Chia đều phí ship cho từng sản phẩm

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoàn tất đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffe6ec, #e3f6f5);
            font-family: 'Segoe UI', sans-serif;
            padding: 40px 10px;
        }

        .thankyou-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            max-width: 800px;
            margin: 0 auto;
        }

        .thankyou-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .thankyou-header i {
            font-size: 60px;
            color: #90e0ef;
        }

        .thankyou-header h2 {
            color: #0081a7;
            font-weight: 600;
            margin-top: 10px;
        }

        .order-info, .order-details {
            margin-top: 20px;
        }

        .order-info h5, .order-details h5 {
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .order-info p {
            margin: 5px 0;
            font-size: 15px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th, .order-details td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .order-details th {
            background-color: #f1f1f1;
        }

        .btn-back-home, .btn-order-history {
            margin-top: 30px;
            display: inline-block;
            padding: 10px 25px;
            background-color: #00b4d8;
            color: #fff;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        .btn-back-home:hover, .btn-order-history:hover {
            background-color: #0077b6;
        }

        .btn-order-history {
            background-color: #00aaff;
        }

        .btn-order-history:hover {
            background-color: #0088cc;
        }
    </style>
</head>
<body>
    <div class="thankyou-container">
        <div class="thankyou-header">
            <i class="fa-solid fa-ice-cream"></i>
            <h2>Đơn hàng đã được đặt thành công!</h2>
            <p>Cảm ơn bạn đã lựa chọn cửa hàng kem của chúng tôi. Chúng tôi sẽ xác nhận đơn và giao hàng sớm nhất có thể.</p>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="order-info">
            <h5>Thông tin đơn hàng</h5>
            <p><strong>Mã hóa đơn:</strong> <?php echo $order['MaHoaDon']; ?></p>
            <p><strong>Người nhận:</strong> <?php echo $order['NguoiNhanHang']; ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?php echo $order['DiaChiCuThe']; ?></p>
           
            <p><strong>Hình thức thanh toán:</strong> <?php echo $order['HinhThucThanhToan']; ?></p>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="order-details">
            <h5>Chi tiết đơn hàng</h5>
            <table>
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_details as $item): ?>
                    <tr>
                        <td><?php echo $item['TenSanPham']; ?></td>
                        <td><?php echo $item['SoLuong']; ?></td>
                        <td><?php echo number_format($item['DonGia'], 0, ',', '.'); ?> VNĐ</td>
                        
                    </tr>
                    
                    <?php endforeach; ?>
                </tbody>
            </table>
         <p><strong>Tổng tiền:</strong> <?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</p>
        </div>

        <div class="text-center">
            <a href="../index.php" class="btn-back-home">Quay lại trang chủ</a>
          <a href="user.php?tab=order-history" class="btn-order-history">Lịch sử đơn hàng</a>

        </div>
    </div>
</body>
</html>
