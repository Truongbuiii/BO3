<?php
session_start();
require("../db/connect.php");

// Kiểm tra nếu có `MaSanPham` được truyền vào
if (!isset($_GET['MaSanPham']) || empty($_GET['MaSanPham'])) {
    echo "<script>alert('Thiếu thông tin sản phẩm!'); window.location.href = '/index.php';</script>";
    exit();
}

$MaSanPham = $_GET['MaSanPham'];

// Truy vấn thông tin sản phẩm
$sql = "SELECT * FROM SanPham WHERE MaSanPham = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaSanPham);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "<script>alert('Sản phẩm không tồn tại!'); window.location.href = '/index.php';</script>";
    exit();
}

if ($product['TinhTrang'] == 0) {
    echo "<script>alert('Sản phẩm này hiện đang tạm khóa!'); window.history.back();</script>";
    exit();
}


// Truy vấn sản phẩm liên quan
$sql_related = "SELECT * FROM SanPham WHERE MaLoai = ? AND MaSanPham != ? LIMIT 3";
$stmt_related = $conn->prepare($sql_related);
$stmt_related->bind_param("ss", $product['MaLoai'], $MaSanPham);
$stmt_related->execute();
$related_products = $stmt_related->get_result();



// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaSanPham'])) {
    $MaSanPham = $_POST['MaSanPham'];

    // Lấy thông tin sản phẩm từ CSDL
    $sql = "SELECT * FROM SanPham WHERE MaSanPham = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MaSanPham);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Nếu sản phẩm đã tồn tại trong giỏ, tăng số lượng
        if (isset($_SESSION['cart'][$MaSanPham])) {
            $_SESSION['cart'][$MaSanPham]['quantity'] += 1;
        } else {
            // Thêm sản phẩm mới vào giỏ
            $_SESSION['cart'][$MaSanPham] = [
                'TenSanPham' => $product['TenSanPham'],
                'DonGia' => $product['DonGia'],
                'HinhAnh' => $product['HinhAnh'],
                'quantity' => 1
            ];
        }

        // Chuyển hướng đến trang giỏ hàng
        echo "<script>window.location.href = 'trangGioHang.php';</script>";
    } else {
        echo "<script>alert('Sản phẩm không tồn tại.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="js/jquery.min.js"></script>
</head>
<body>

<style>
.product-info {
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    color: #333;
}

.product-title {
    font-size: 24px;
    font-weight: 700;
    color: #222;
}

.product-price {
    font-size: 20px;
    font-weight: bold;
    color: #e74c3c;
}

.product-flavor, .product-description {
    font-size: 16px;
    color: #555;
}

.btn-success {
    font-size: 16px;
    font-weight: 500;
}
</style>

<!-- Header -->
<div class="header_section header_bg">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/index.php">
                <img src="/images/logo.png">
            </a>
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
                <ul class="navbar-nav ml-3 d-flex align-items-center">
                    <li class="nav-item"><a class="nav-link" href="trangHoSo.php"><i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 150%;"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="trangGioHang.php"><i class="bi bi-bag-heart-fill custom-icon" style="font-size: 150%; color:#fc95c4;"></i></a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<!-- Chi tiết sản phẩm -->
<div class="container product-detail-container">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <div class="product-images">
                <img src="/images/<?php echo $product['HinhAnh']; ?>" alt="<?php echo $product['TenSanPham']; ?>" class="product-main-image">
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <div class="product-info">
                <h1 class="product-title"><?php echo $product['TenSanPham']; ?></h1>
                <p class="product-price"><strong>Giá: </strong> <?php echo number_format($product['DonGia']); ?> VND</p>
                <p class="product-flavor"><strong>Hương vị: </strong> <?php echo $product['HuongVi']; ?></p>
                <p class="product-description">Diển giải : <?php echo $product['DienGiai']; ?></p>
                <p class="tinhtrang">Tình trạng : <?php echo $product['TinhTrang']? "<span class='text-success'>Còn hàng</span>" : "<span class='text-danger'>Khóa</span>" ; ?></p>
                <form method="POST">
                    <button class="btn btn-success" name="MaSanPham" value="<?php echo $product['MaSanPham']; ?>">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sản phẩm liên quan -->
  <!-- Sản phẩm liên quan -->
<div class="related-products mt-5">
    <h2 class="related-title text-center">Sản phẩm liên quan</h2>
    <div class="row justify-content-center">
        <?php while ($related = $related_products->fetch_assoc()) { ?>
            <div class="col-md-4 d-flex justify-content-center">
                <div class="related-item text-center">
                    <a href="chitietsanpham.php?MaSanPham=<?php echo $related['MaSanPham']; ?>">
                        <img src="/images/<?php echo $related['HinhAnh']; ?>" alt="<?php echo $related['TenSanPham']; ?>" class="related-image img-fluid">
                    </a>
                    <p class="mt-2"><strong><?php echo $related['TenSanPham']; ?></strong></p>
                    <p class="text-danger"><?php echo number_format($related['DonGia']); ?> VND</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>
<!-- Footer -->
 <div class="contact_section layout_padding">
         <div class="container">
             <div class="row">
                 <div class="col-md-8">
                     <div class="location_text">
                         <ul>
                             <li>
                                 <a href="#">
                                     <span class="padding_left_10 active"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                     1234 Cây kem, Phường 1, Quận 2, Thành Phố Hồ Chí Minh, Trái Đất.
                                 </a>
                             </li>
                             <li>
                                 <a href="#">
                                     <span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                     Call : +01 23456789
                                 </a>
                             </li>
                             <li>
                                 <a href="#">
                                     <span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                     Email : BeYeukem1234@gmail.com
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </div>
             </div>
             <div class="footer_social_icon">
                 <ul>
                     <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                 </ul>
             </div>
             <div class="copyright_section">
               <div class="container">
                  <p class="copyright_text">All Rights Reserved. Design by TiemKemF4</a></p>
               </div>
            </div>
         </div>
     </div>



 


      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/main.js"></script>
      <!-- javascript --> 

      
   </body>
</html> 