<?php
require 'includes/header.php';
require './db/connect.php'; // Kết nối cơ sở dữ liệu

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $query = "
        SELECT  kh.TenNguoiDung, SUM(dh.TongTien) AS TongChiTieu 
        FROM NguoiDung kh
        JOIN HoaDon dh ON kh.TenNguoiDung = dh.TenNguoiDung
        WHERE dh.NgayGio BETWEEN ? AND ?
        GROUP BY  kh.TenNguoiDung
        ORDER BY TongChiTieu DESC
        LIMIT 5
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $top_customers = [];
    while ($row = $result->fetch_assoc()) {
        $top_customers[] = $row;
    }
}
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Thống kê 5 khách hàng mua nhiều nhất</h1>
            </div>
            <form method="post" class="user text-center">
                <div class="form-group">
                    <label>Từ ngày:</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Đến ngày:</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Thống kê</button>
            </form>
            
            <?php if (!empty($top_customers)): ?>
                <h3 class="text-center mt-4">Kết quả thống kê</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Tên khách hàng</th>
                                <th>Tổng chi tiêu (VNĐ)</th>
                                <th>Chi tiết đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_customers as $customer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer['TenNguoiDung']); ?></td>
                                    <td><?php echo number_format($customer['TongChiTieu'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>
                                        <a href="order_details.php?customer_id=<?php echo $customer['MaNguoiDung']; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-info btn-sm">
                                            Xem đơn hàng
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require 'includes/footer.php';
?>
