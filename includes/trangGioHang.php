<?php
session_start();

// Kiểm tra nếu giỏ hàng đã tồn tại trong session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng của bạn hiện tại không có sản phẩm nào!'); window.location.href = '/index.php';</script>";
    exit();
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    $removeProduct = $_GET['remove'];
    unset($_SESSION['cart'][$removeProduct]);
}

// Xử lý cập nhật số lượng sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaSanPham']) && isset($_POST['quantity'])) {
    $MaSanPham = $_POST['MaSanPham'];
    $quantity = $_POST['quantity'];
    if ($quantity > 0) {
        $_SESSION['cart'][$MaSanPham]['quantity'] = $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>

<div class="header_section header_bg">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/index.php">
                <img src="/images/logo.png">
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="/index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemLy.php">Kem ly</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemOcQue.php">Kem ốc quế</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemQue.php">Kem que</a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="container">
    <h2 class="my-4">Giỏ hàng của bạn</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $MaSanPham => $item) {
                $total += $item['DonGia'] * $item['quantity'];
            ?>
            <tr>
                <td><img src="/images/<?php echo $item['HinhAnh']; ?>" alt="<?php echo $item['TenSanPham']; ?>" width="80"></td>
                <td><?php echo $item['TenSanPham']; ?></td>
                <td><?php echo number_format($item['DonGia'], 0, ',', '.'); ?> VND</td>
                <td>
                    <form method="POST">
                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 50px;">
                        <input type="hidden" name="MaSanPham" value="<?php echo $MaSanPham; ?>">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </td>
                <td><?php echo number_format($item['DonGia'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                <td><a href="trangGioHang.php?remove=<?php echo $MaSanPham; ?>" class="btn btn-danger">Xóa</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3 class="text-right">Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VND</h3>

    <div class="text-center mt-4">
        <a href="checkout.php" class="btn btn-success">Tiến hành thanh toán</a>
    </div>
</div>

</body>
</html>
