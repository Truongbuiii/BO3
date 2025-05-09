<?php
session_start();
require_once __DIR__ . '/../kiemtradangnhap.php';

if (!isset($_GET['MaSanPham']) || empty($_GET['MaSanPham'])) {
    echo "<script>alert('Thiếu thông tin sản phẩm!'); window.location.href = '/index.php';</script>";
    exit();
}

$MaSanPham = $_GET['MaSanPham'];

// Lấy thông tin sản phẩm
$sql = "SELECT * FROM SanPham WHERE MaSanPham = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaSanPham);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Sản phẩm không tồn tại!'); window.location.href = '/index.php';</script>";
    exit();
}

$product = $result->fetch_assoc();

if ($product['TinhTrang'] == 0) {
    echo "<script>alert('Sản phẩm này hiện đang tạm khóa!'); window.history.back();</script>";
    exit();
}

// Xử lý thêm giỏ hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaSanPham'])) {
   
    if (!isset($_SESSION['TenNguoiDung'])) {
        echo "<script>alert('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!'); window.location.href = 'login.php';</script>";
        exit();
    }

    $maSanPhamPost = $_POST['MaSanPham'];
    $stmt = $conn->prepare("SELECT * FROM SanPham WHERE MaSanPham = ?");
    $stmt->bind_param("s", $maSanPhamPost);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('Sản phẩm không tồn tại.'); window.location.href = '/index.php';</script>";
        exit();
    }

    $productPost = $result->fetch_assoc();

    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    if (isset($_SESSION['cart'][$maSanPhamPost])) {
        $_SESSION['cart'][$maSanPhamPost]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$maSanPhamPost] = [
            'TenSanPham' => $productPost['TenSanPham'],
            'DonGia' => $productPost['DonGia'],
            'HinhAnh' => $productPost['HinhAnh'],
            'quantity' => 1
        ];
    }

    echo "<script>window.location.href = 'trangGioHang.php';</script>";
    exit();
}

// Lấy sản phẩm liên quan
$sql_related = "SELECT * FROM SanPham WHERE MaLoai = ? AND MaSanPham != ? LIMIT 3";
$stmt_related = $conn->prepare($sql_related);
$stmt_related->bind_param("ss", $product['MaLoai'], $MaSanPham);
$stmt_related->execute();
$related_products = $stmt_related->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="js/jquery.min.js"></script>

    <style>
        .product-info { font-family: 'Roboto', sans-serif; font-size: 16px; color: #333; }
        .product-title { font-size: 24px; font-weight: 700; color: #222; }
        .product-price { font-size: 20px; font-weight: bold; color: #e74c3c; }
        .product-flavor, .product-description { font-size: 16px; color: #555; }
        .btn-success { font-size: 16px; font-weight: 500; }
        .related-image { width: 80%; height: auto; border-radius: 10px; }
    </style>
</head>
<body>

<!-- Header -->
<div class="header_section header_bg">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/index.php"><img src="/images/logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="/index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemLy.php">Kem ly</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemOcQue.php">Kem ốc quế</a></li>
                    <li class="nav-item"><a class="nav-link" href="kemQue.php">Kem que</a></li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm...">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <ul class="navbar-nav ml-3">
                    <li class="nav-item d-flex align-items-center">
                        <a href="#" onclick="handleUserClick()">
                            <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                        </a>
                        <a href="#" onclick="handleCartClick()">
                            <i class="bi bi-bag-heart-fill custom-icon" style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                        </a>
                        <?php if (isset($_SESSION['username'])): ?>
                            <span style="color: #fc95c4; font-weight: bold; padding-left: 10px;">
                                Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </span>
                            <a href="logout.php" class="btn btn-outline-danger ml-2">Đăng xuất</a>
                        <?php endif; ?>
                    </li>
                </ul>
                <script>
                    const isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
                    function handleUserClick() {
                        if (isLoggedIn) window.location.href = "includes/userProfile.php";
                        else window.location.href = "login.php";
                    }
                    function handleCartClick() {
                        if (isLoggedIn) window.location.href = "includes/trangGioHang.php";
                        else {
                            alert("Bạn cần đăng nhập để xem giỏ hàng!");
                            window.location.href = "login.php";
                        }
                    }
                </script>
            </div>
        </nav>
    </div>
</div>

<!-- Chi tiết sản phẩm -->
<div class="container product-detail-container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="/images/<?php echo $product['HinhAnh']; ?>" alt="<?php echo $product['TenSanPham']; ?>" class="product-main-image img-fluid rounded">
        </div>
        <div class="col-md-6 product-info">
            <h1 class="product-title"><?php echo $product['TenSanPham']; ?></h1>
            <p class="product-price">Giá: <?php echo number_format($product['DonGia']); ?> VND</p>
            <p class="product-flavor"><strong>Hương vị:</strong> <?php echo $product['HuongVi']; ?></p>
            <p class="product-description">Diễn giải: <?php echo $product['DienGiai']; ?></p>
            <p>Tình trạng: <?php echo $product['TinhTrang'] ? "<span class='text-success'>Còn hàng</span>" : "<span class='text-danger'>Khóa</span>"; ?></p>
            <form method="POST">
                <button class="btn btn-success" name="MaSanPham" value="<?php echo $product['MaSanPham']; ?>">Thêm vào giỏ hàng</button>
            </form>
        </div>
    </div>

    <!-- Sản phẩm liên quan -->
    <div class="related-products mt-5">
        <h2 class="text-center">Sản phẩm liên quan</h2>
        <div class="row justify-content-center">
            <?php while ($related = $related_products->fetch_assoc()) { ?>
                <div class="col-md-4 text-center mb-4">
                    <a href="chitietsanpham.php?MaSanPham=<?php echo $related['MaSanPham']; ?>">
                        <img src="/images/<?php echo $related['HinhAnh']; ?>" class="related-image" alt="<?php echo $related['TenSanPham']; ?>">
                    </a>
                    <p class="mt-2 font-weight-bold"><?php echo $related['TenSanPham']; ?></p>
                    <p class="text-danger"><?php echo number_format($related['DonGia']); ?> VND</p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="contact_section layout_padding mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="location_text">
                    <ul>
                        <li><a href="#"><i class="fa fa-map-marker"></i> 1234 Cây kem, Phường 1, Quận 2, TP.HCM</a></li>
                        <li><a href="#"><i class="fa fa-phone"></i> Call : +01 23456789</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i> Email : BeYeukem1234@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer_social_icon text-center mt-3">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</div>

</body>
</html>
