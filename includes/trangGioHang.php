<?php
session_start();
require_once __DIR__ . '/../kiemtradangnhap.php';
// Xử lý xóa sản phẩm
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header('Location: trangGioHang.php');
    exit;
}
// Xử lý cập nhật số lượng sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaSanPham']) && isset($_POST['quantity'])) {
    $MaSanPham = $_POST['MaSanPham'];
    $quantity = $_POST['quantity'];
    if ($quantity > 0) {
        $_SESSION['cart'][$MaSanPham]['quantity'] = $quantity; // Cập nhật số lượng
    } else {
        echo "<script>alert('Số lượng không hợp lệ!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
   <div class="header_section header_bg">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="/index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemLy.php">Kem ly</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemOcQue.php">Kem ốc quế</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemQue.php">Kem que</a></li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                     <input class="form-control mr-sm-2" type="search" name="search" placeholder="Tìm kiếm..." aria-label="Search">
                     <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                     </button>
                  </form>
                  
                <ul class="navbar-nav ml-3">
                    <li class="nav-item d-flex align-items-center">
                        <a href="user.php" onclick="handleUserClick()">
                            <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%; padding-left:10px;"></i>
                        </a>
                        <a href="trangGioHang.php" onclick="handleCartClick()">
                            <i class="bi bi-bag-heart-fill" style="color:#fc95c4; font-size: 220%; padding-left:10px;"></i>
                        </a>
                        <?php if (isset($_SESSION['username'])): ?>
                            <span style="color: #fc95c4; font-weight: bold; padding-left: 10px;">
                                Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </span>
                           
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="container">
    <h1 class="my-4 text-center fw-bold">Giỏ hàng của bạn</h1>

    <!-- Bắt đầu form để gửi dữ liệu giỏ hàng -->
    <form method="POST" action="trangThanhToan.php">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $MaSanPham => $item) {
                    $total += $item['DonGia'] * $item['quantity'];
                    ?>
                    <tr>
                        <td><img src="/images/<?php echo $item['HinhAnh']; ?>" alt="<?php echo $item['TenSanPham']; ?>" width="80"></td>
                        <td><?php echo $item['TenSanPham']; ?></td>
                        <td id="price-<?php echo $MaSanPham; ?>" data-price="<?php echo $item['DonGia']; ?>">
                            <?php echo number_format($item['DonGia'], 0, ',', '.'); ?> VND
                        </td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm"
                                    onclick="updateQuantity('<?php echo $MaSanPham; ?>', -1)">-
                            </button>
                            <span id="quantity-<?php echo $MaSanPham; ?>"><?php echo $item['quantity']; ?></span>
                            <button type="button" class="btn btn-secondary btn-sm"
                                    onclick="updateQuantity('<?php echo $MaSanPham; ?>', 1)">+
                            </button>

                            <input type="hidden" name="cart[<?php echo $MaSanPham; ?>][MaSanPham]"
                                   value="<?php echo $MaSanPham; ?>">
                            <input type="hidden" id="input-<?php echo $MaSanPham; ?>"
                                   name="cart[<?php echo $MaSanPham; ?>][quantity]"
                                   value="<?php echo $item['quantity']; ?>">
                            <input type="hidden" name="cart[<?php echo $MaSanPham; ?>][DonGia]"
                                   value="<?php echo $item['DonGia']; ?>">
                        </td>
                        <td><a href="trangGioHang.php?remove=<?php echo $MaSanPham; ?>"
                               class="btn btn-danger">Xóa</a></td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="5" class="text-center">Giỏ hàng trống</td></tr>';
            }
            ?>
            </tbody>
        </table>

        <h3 class="text-right">
            Tổng cộng: <span id="total-price"><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
        </h3>

        <div class="text-center mt-4">
            <button type="submit" class="btn"
                    style="background-color: #fc95c4; color: white; padding: 12px 28px; border-radius: 6px; font-size: 18px; border: none;">
                Thanh toán
            </button>
        </div>
    </form>

    <div class="text-center mt-2">
        <a href="/index.php" style="color:black; font-size: 18px; text-decoration: none;">Quay lại</a>
    </div>
</div>

<!-- SCRIPT để cập nhật tổng tiền -->
<script>
function updateQuantity(productId, change) {
    const quantitySpan = document.getElementById('quantity-' + productId);
    const input = document.getElementById('input-' + productId);
    const priceCell = document.getElementById('price-' + productId);
    const price = parseInt(priceCell.dataset.price);

    let quantity = parseInt(quantitySpan.textContent);
    quantity += change;

    if (quantity < 1) quantity = 1;

    quantitySpan.textContent = quantity;
    input.value = quantity;

    // Gửi dữ liệu về server để cập nhật số lượng trong session
    fetch('trangGioHang.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `MaSanPham=${productId}&quantity=${quantity}`
    })
    .then(response => response.text())
    .then(data => {
        // Cập nhật lại tổng tiền sau khi thay đổi số lượng
        updateTotal();
    });
}

</script>
</body>
</html>
