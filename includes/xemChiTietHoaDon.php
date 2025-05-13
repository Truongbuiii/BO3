<?php
// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "b03db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu có mã hóa đơn
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Lấy thông tin hóa đơn
    $orderSql = "SELECT * FROM HoaDon WHERE MaHoaDon = ?";
    $stmt = $conn->prepare($orderSql);
    if ($stmt === false) {
        die('Error in SQL query: ' . $conn->error);
    }
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $orderResult = $stmt->get_result();

    if ($orderResult->num_rows > 0) {
        $order = $orderResult->fetch_assoc();

        // Lấy chi tiết hóa đơn có JOIN sản phẩm
        $orderDetailsSql = "
            SELECT cthd.SoLuong, sp.TenSanPham, cthd.DonGia
            FROM ChiTietHoaDon cthd
            JOIN SanPham sp ON cthd.MaSanPham = sp.MaSanPham
            WHERE cthd.MaHoaDon = ?
        ";
        $stmt = $conn->prepare($orderDetailsSql);
        if ($stmt === false) {
            die('Error in SQL query: ' . $conn->error);
        }
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $orderDetailsResult = $stmt->get_result();
    } else {
        echo "Đơn hàng không tồn tại.";
        exit;
    }
} else {
    echo "Không có mã đơn hàng.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css"> <!-- Đường dẫn CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f1f1f1;
            color: #555;
        }

        table td {
            font-size: 16px;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        h4 {
            font-size: 20px;
            margin-top: 30px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Chi tiết đơn hàng #<?= htmlspecialchars($order['MaHoaDon']) ?></h3>
    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['TrangThai']) ?></p>

    <h4>Chi tiết sản phẩm:</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($detail = $orderDetailsResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($detail['TenSanPham']) . "</td>";
                echo "<td>" . htmlspecialchars($detail['SoLuong']) . "</td>";
                echo "<td>" . number_format($detail['DonGia'], 0, ',', '.') . " VND</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="user.php" class="btn btn-secondary">Quay lại</a>
</div>

</body>
</html>
