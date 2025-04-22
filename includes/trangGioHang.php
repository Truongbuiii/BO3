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
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Trang chủ</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="/images/fevicon.png" type="image/gif" />
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

      <style>
         /* Nền che lại hình tròn lớn màu hồng */
         .bg-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            background-color: #f8b5d1; /* Màu hồng */
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1; /* Đảm bảo hình tròn nằm dưới các phần tử khác */
         }

         /* Cải thiện bảng giỏ hàng */
         .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
         }

         .table th, .table td {
            text-align: center;
            vertical-align: middle;
            background-color: white;
            font-size: 18px;
         }

         .table th {
            background-color: rgb(230, 241, 247);
            color: rgb(228, 14, 64);
            font-size: 18px;
         }

         .table tr {
            transition: background-color 0.3s ease;
         }

         .table tr:hover {
            background-color: #fff3f5;
         }

         .item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
         }

         .item-img:hover {
            transform: scale(1.05);
         }

         /* Hành động giỏ hàng */
         #cart-action {
            margin-top: 20px;
         }

         /* Nút thanh toán với màu đỏ và dấu mũi tên ngược */
.nut-thanh-toan {
   width: 20%;
   padding: 12px;
   background-color: #d1071e; /* Đổi màu thành đỏ */
   color: white;
   border: none;
   border-radius: 8px;
   font-size: 16px;
   margin-top: 20px;
   cursor: pointer;
   transition: background-color 0.3s ease;
}

.nut-thanh-toan i {
   margin-right: 10px; /* Tạo khoảng cách giữa mũi tên và văn bản */
}

.nut-thanh-toan:hover {
   background-color:rgb(198, 0, 0); /* Màu đỏ khi hover */
}

         /* Nút thanh toán và tiếp tục mua hàng */
         .btn-checkout {
            background-color: #cc0000 !important;
            color: white !important;
            padding: 12px 28px;
            border-radius: 6px;
            font-size: 18px;
            border: none;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 8px rgba(204, 0, 0, 0.3);
            margin-top: 10px;
            margin-right: 15px;
         }

         .btn-checkout:hover {
            background-color: #a80000 !important;
         }

         .btn-continue {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            margin-right: 15px;
         }

         /* Nút xóa sản phẩm */
         .btn-danger {
            background-color: rgb(233, 28, 28) !important;
            color: white !important;
            border: none;
            padding: 8px 20px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 2px 8px rgba(204, 0, 0, 0.3);
            margin-top: 10px;
            margin-right: 15px;
         }

         .btn-danger:hover {
            background-color: #a80000 !important;
         }

         .btn {
            border-radius: 10px;
            font-weight: 500;
         }

         /* Tiêu đề và mô tả trang */
         .banner_taital {
            font-size: 40px;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.95);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
         }

         .banner_text {
            font-size: 18px;
            color: black;
            font-weight: 500;
            margin-bottom: 8px;
         }
         .table-bordered {
   border: none !important;
}

.table-bordered td, .table-bordered th {
   border: 1px solid #dee2e6 !important;
}

      </style>
   </head>
   <body>
      <div class="header_section">
         <!-- Nền che hình tròn màu hồng -->
         <div class="bg-circle"></div> 

         <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="/index.php"><img src="/images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav">
                     <li class="nav-item active">
                        <a class="nav-link" href="/index.php">Trang chủ</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="kemLy.php">Kem ly</a> 
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="kemOcQue.php">Kem ốc quế</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="kemQue.php">Kem que</a>
                     </li>
                  </ul>
                  <li>
                     <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                           <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                     </form>
                  </li>
                  <ul class="navbar-nav">
                     <div class="login_bt"><a href="#"><i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 150%;"></i></a><i class="bi bi-bag-heart-fill custom-icon"></i>
                  </form>
               </div>
            </nav>
         </div>
<div class="container">
<h1 class="my-4 text-center fw-bold">Giỏ hàng của bạn</h1>


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
                     <button type="button" class="btn btn-secondary btn-sm" onclick="updateQuantity('<?php echo $MaSanPham; ?>', -1)">-</button>
                     <span id="quantity-<?php echo $MaSanPham; ?>"><?php echo $item['quantity']; ?></span>
                     <button type="button" class="btn btn-secondary btn-sm" onclick="updateQuantity('<?php echo $MaSanPham; ?>', 1)">+</button>
                     <input type="hidden" name="MaSanPham" value="<?php echo $MaSanPham; ?>">
                     <input type="hidden" name="quantity" id="hidden-quantity-<?php echo $MaSanPham; ?>" value="<?php echo $item['quantity']; ?>">
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
    <a href="trangThanhToan.php" class="btn" style="background-color: #fc95c4; color: white; padding: 12px 28px; border-radius: 6px; font-size: 18px; border: none;">Thanh toán</a>
</div>

    <div class="text-center mt-2">
    <a href="/index.php" style="color:black; font-size: 18px; text-decoration: none;">Quay lại</a>
</div>

</div>

<div class="contact_section layout_padding">
    <div class="container-fluid"> <!-- Đổi container thành container-fluid -->
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
                  <p class="copyright_text">2020 All Rights Reserved. Design by <a href="https://html.design">Free Html Templates</a> Distribution by <a href="https://themewagon.com">ThemeWagon</a></p>
               </div>
            </div>
         </div>
     </div>
    <script>function updateQuantity(MaSanPham, change) {
    var quantityElement = document.getElementById('quantity-' + MaSanPham);
    var hiddenQuantityElement = document.getElementById('hidden-quantity-' + MaSanPham);
    
    // Cập nhật số lượng trên giao diện
    var currentQuantity = parseInt(quantityElement.textContent);
    var newQuantity = currentQuantity + change;
    if (newQuantity > 0) {
        quantityElement.textContent = newQuantity;
        hiddenQuantityElement.value = newQuantity;

        // Gửi yêu cầu cập nhật số lượng qua POST
        var form = quantityElement.closest('form');
        form.submit();
    }
}


</script>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
   </body>
</html>