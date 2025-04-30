<?php
session_start();

// Kiểm tra nếu giỏ hàng trống thì chuyển hướng về trang chủ
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Không có sản phẩm để thanh toán!'); window.location.href = '/index.php';</script>";
    exit();
}
?>
  <script>
    const isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
</script>

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
      .checkout-wrapper {
         display: flex;
         justify-content: space-between;
         align-items: flex-start;
         max-width: 1300px;
         margin: auto;
         gap: 40px;
      }

      .checkout-container, .order-summary {
         flex: 0.5;
         padding: 30px;
         border: 1px solid #ddd;
         border-radius: 10px;
         background-color: #f9f9f9;
         font-size: 14px;
      }

      .order-summary h2, .checkout-container h2 {
         text-align: center;
         font-size: 24px;
         margin-bottom: 20px;
      }

      .form-group {
         margin-bottom: 15px;
      }

      .form-group label {
         font-weight: bold;
         display: block;
      }

      .form-group input {
         width: 100%;
         padding: 8px;
         margin-top: 5px;
         border: 1px solid #ccc;
         border-radius: 5px;
      }

      .required {
         color: red;
      }

      .btn-submit {
         background-color: orange;
         color: white;
         padding: 10px;
         border: none;
         width: 100%;
         border-radius: 5px;
         cursor: pointer;
         font-size: 14px;
         margin-top: 20px;
      }

      .btn-back-cart {
         display: block;
         text-align: center;
         margin-top: 15px;
         padding: 10px;
         background-color: #f44336;
         color: white;
         text-decoration: none;
         border-radius: 5px;
      }

      .payment-method {
         padding: 15px;
         border: 1px solid #ddd;
         border-radius: 5px;
         background-color: #fff3cd;
         margin-top: 20px;
      }

      .hidden {
         display: none;
      }
   </style>


</style>
   </head>
   <body>
      <div class="header_section">
         <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand"href="/index.php"><img src="/images/logo.png"></a>
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
                     <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                     <input class="form-control mr-sm-2" type="search" name="search" placeholder="Tìm kiếm..." aria-label="Search">
                     <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                     </button>
                  </form>
                  </li>
                  <ul class="navbar-nav ml-3">
            <li class="nav-item d-flex align-items-center">
               
                        <a href="#" onclick="handleUserClick()">
                        <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                        </a>
                        <a href="#" onclick="handleCartClick()">
                            <i class="bi bi-bag-heart-fill custom-icon"  style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                        </a>

                        <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <span style="color: #fc95c4; font-weight: bold; padding-left: 10px;">
                                Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </span>
                            <a href="logout.php" class="btn btn-outline-danger ml-2">Đăng xuất</a>
                        </li>
                        
                        
                         <?php endif; ?>

             </li>
             </ul>

                  </form>
               </div>
            </nav>
         </div>



    <!-- Checkout Form Section -->
    <div class="container my-5 checkout-wrapper">
        <div class="checkout-container">
            <h2>Thông tin thanh toán</h2>
            <form id="checkout-form">
                <div class="form-group">
                    <label for="name">Họ và tên <span class="required">*</span></label>
                    <input type="text" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại <span class="required">*</span></label>
                    <input type="text" id="phone" required>
                </div>
                <div class="form-group">
                    <label>Chọn địa chỉ giao hàng <span class="required">*</span></label>
                    <input type="radio" name="address-option" id="use-account" checked> Dùng địa chỉ tài khoản
                    <input type="radio" name="address-option" id="enter-new" style="margin-left:20px;"> Nhập địa chỉ mới
                </div>

                <!-- Account Address -->
                <div id="account-address">
                    <div class="form-group">
                        <label for="city">Tỉnh/Thành phố</label>
                        <input type="text" id="city" disabled>
                    </div>
                    <div class="form-group">
                        <label for="district">Quận/Huyện</label>
                        <input type="text" id="district" disabled>
                    </div>
                    <div class="form-group">
                        <label for="ward">Phường/Xã</label>
                        <input type="text" id="ward" disabled>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                        <input type="text" id="address" required>
                    </div>
                </div>

                <!-- New Address -->
                <div id="new-address" class="hidden">
                    <div class="form-group">
                        <label for="new-city">Tỉnh/Thành phố <span class="required">*</span></label>
                        <input type="text" id="new-city">
                    </div>
                    <div class="form-group">
                        <label for="new-district">Quận/Huyện <span class="required">*</span></label>
                        <input type="text" id="new-district">
                    </div>
                    <div class="form-group">
                        <label for="new-ward">Phường/Xã <span class="required">*</span></label>
                        <input type="text" id="new-ward">
                    </div>
                    <div class="form-group">
                        <label for="new-address">Địa chỉ cụ thể <span class="required">*</span></label>
                        <input type="text" id="new-address">
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="form-group">
                    <label for="payment-method">Chọn phương thức thanh toán <span class="required">*</span></label>
                    <select id="payment-method" required>
                        <option value="online">Thanh toán trực tuyến</option>
                        <option value="cod">Tiền mặt khi nhận hàng</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="order-summary">
            <h2>Đơn hàng của bạn</h2>
            <?php
            // Check if cart is not empty
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $tongTien = 0;
                echo "<ul>";
                foreach ($_SESSION['cart'] as $item) {
                    $thanhTien = $item['DonGia'] * $item['quantity'];
                    $tongTien += $thanhTien;
                    echo "<li><strong>{$item['TenSanPham']}</strong> - " . number_format($item['DonGia'], 0, ',', '.') . " VND x {$item['quantity']} = " . number_format($thanhTien, 0, ',', '.') . " VND</li>";
                }
                echo "</ul>";
                $shippingFee = 30000; // example shipping fee
                $totalAmount = $tongTien + $shippingFee;
                echo "<p><strong>Tạm tính:</strong> " . number_format($tongTien, 0, ',', '.') . " VND</p>";
                echo "<p><strong>Giao hàng:</strong> " . number_format($shippingFee, 0, ',', '.') . " VND</p>";
                echo "<p><strong>Tổng:</strong> <span style='color:red; font-weight: bold;'>" . number_format($totalAmount, 0, ',', '.') . " VND</span></p>";
            } else {
                echo "<p>Không có sản phẩm trong giỏ hàng.</p>";
            }
            ?>

            <button type="button" class="btn-submit" onclick="confirmPayment()">Xác nhận thanh toán</button>
            <a href="trangGioHang.php" class="btn-back-cart">Quay lại giỏ hàng</a>
        </div>
    </div>

    <script>
        // Show/Hide address forms based on selected option
        document.getElementById('use-account').addEventListener('change', function() {
            document.getElementById('account-address').style.display = 'block';
            document.getElementById('new-address').style.display = 'none';
        });

        document.getElementById('enter-new').addEventListener('change', function() {
            document.getElementById('account-address').style.display = 'none';
            document.getElementById('new-address').style.display = 'block';
        });

        // Confirm Payment Logic
        function confirmPayment() {
            let form = document.getElementById('checkout-form');
            let valid = form.checkValidity();
            if (valid) {
                alert("Thanh toán thành công!");
            } else {
                alert("Vui lòng điền đầy đủ thông tin!");
            }
        }
    </script>
          <script src="/js/main.js"></script>

</body>
</html>
