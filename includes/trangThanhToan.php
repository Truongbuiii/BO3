<?php
session_start();
if (!isset($_SESSION['gio_hang']) || empty($_SESSION['gio_hang'])) {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href='index.html';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<!-- header.php -->
<header>
    <div class="container">
        <nav class="navbar">
            <!-- Logo -->
            <a class="navbar-brand" href="index.html">
                <img src="images/logo.png" alt="Logo">
            </a>

            <!-- Menu ngang -->
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.html">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ly</a></li>
                <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ốc quế</a></li>
                <li class="nav-item"><a class="nav-link" href="icecream.html">Kem que</a></li>
            </ul>

            <!-- Thanh tìm kiếm -->
            <div class="search-container">
                <input type="text" placeholder="Tìm kiếm...">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <!-- Icon tài khoản & giỏ hàng -->
            <div class="icon-group">
                <a href="#"><i class="fa-solid fa-user-large"></i></a>
                <a href="includes/trangGioHang.php"><i class="bi bi-bag-heart-fill"></i></a>
            </div>
        </nav>
    </div>
</header>


<div class="container mt-5">
    <h2 class="text-center">Xác nhận Thanh Toán</h2>
    <form action="xacNhanDonHang.php" method="post">
        <div class="mb-3">
            <label for="hoTen" class="form-label">Họ và tên:</label>
            <input type="text" class="form-control" id="hoTen" name="hoTen" required>
        </div>
        <div class="mb-3">
            <label for="sdt" class="form-label">Số điện thoại:</label>
            <input type="text" class="form-control" id="sdt" name="sdt" required>
        </div>
        <div class="mb-3">
            <label for="diaChi" class="form-label">Địa chỉ giao hàng:</label>
            <input type="text" class="form-control" id="diaChi" name="diaChi" required>
        </div>
        <h4>Tổng tiền: <strong><?php echo $_SESSION['tong_tien']; ?>đ</strong></h4>
        <button type="submit" class="btn btn-success">Xác nhận đơn hàng</button>
    </form>
</div>

</body>
</html>
