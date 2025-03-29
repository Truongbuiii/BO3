<?php
require 'includes/header.php';
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">THỐNG KÊ</h1>
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
            
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <h3 class="text-center mt-4"> 5 khách hàng có mức mua hàng cao nhất</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Tên khách hàng</th>
                                <th>Tổng mua</th>
                                <th>Chi tiết đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nguyễn Văn A</td>
                                <td>5,000,000 VNĐ</td>
                                <td>
                                    <a href="order_details.php?customer_id=1" class="btn btn-info btn-sm">Xem đơn hàng</a>
                                    <ul>
                                        <li>Đơn hàng #101 - 2,000,000 VNĐ</li>
                                        <li>Đơn hàng #102 - 3,000,000 VNĐ</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Trần Thị B</td>
                                <td>4,200,000 VNĐ</td>
                                <td>
                                    <a href="order_details.php?customer_id=2" class="btn btn-info btn-sm">Xem đơn hàng</a>
                                    <ul>
                                        <li>Đơn hàng #103 - 1,200,000 VNĐ</li>
                                        <li>Đơn hàng #104 - 3,000,000 VNĐ</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <h3 class="text-center mt-4">Các đơn hàng</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Ngày mua</th>
                                <th>Tổng tiền</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#102</td>
                                <td>Nguyễn Văn A</td>
                                <td>2024-03-25</td>
                                <td>3,000,000 VNĐ</td>
                                <td><a href="order_details.php?order_id=102" class="btn btn-info btn-sm">Xem đơn hàng</a></td>
                            </tr>
                            <tr>
                                <td>#104</td>
                                <td>Trần Thị B</td>
                                <td>2024-03-20</td>
                                <td>3,000,000 VNĐ</td>
                                <td><a href="order_details.php?order_id=104" class="btn btn-info btn-sm">Xem đơn hàng</a></td>
                            </tr>
                            <tr>
                                <td>#101</td>
                                <td>Nguyễn Văn A</td>
                                <td>2024-03-15</td>
                                <td>2,000,000 VNĐ</td>
                                <td><a href="order_details.php?order_id=101" class="btn btn-info btn-sm">Xem đơn hàng</a></td>
                            </tr>
                            <tr>
                                <td>#103</td>
                                <td>Trần Thị B</td>
                                <td>2024-03-10</td>
                                <td>1,200,000 VNĐ</td>
                                <td><a href="order_details.php?order_id=103" class="btn btn-info btn-sm">Xem đơn hàng</a></td>
                            </tr>
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

<?php
require 'includes/header.php';
require 'db/connect.php'; // Kết nối cơ sở dữ liệu

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $query = "
        SELECT c.customer_id, c.name, SUM(o.total_price) AS total_spent 
        FROM customers c
        JOIN orders o ON c.customer_id = o.customer_id
        WHERE o.order_date BETWEEN ? AND ?
        GROUP BY c.customer_id, c.name
        ORDER BY total_spent DESC
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
                                <th>Tổng mua</th>
                                <th>Chi tiết đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_customers as $customer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                    <td><?php echo number_format($customer['total_spent'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>
                                        <a href="order_details.php?customer_id=<?php echo $customer['customer_id']; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-info btn-sm">
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
