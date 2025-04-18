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

.checkout-container {
    flex: 0.50; /* nhỏ hơn một chút */
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    font-size: 14px;
}

.order-summary {
    flex: 0.50; /* lớn hơn một chút */
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    font-size: 14px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.order-summary h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
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
    display: inline-block;
}

.form-group {
    margin-bottom: 15px;
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

.payment-method p {
    margin: 0;
}



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


    
<div class="container my-5 checkout-wrapper">
    <div class="checkout-container">
        <h2 class="text-center">Thông tin thanh toán</h2>
        <form id="checkout-form">
            <div class="form-group">
                <label for="name">Họ và tên <span class="required">*</span></label>
                <input type="text" id="name" required>
            </div>
            <div class="form-group">
    <label for="email">Email <span class="required">*</span></label>
    <input type="email" id="email">
</div>
            <div class="form-group">
                <label for="phone">Số điện thoại <span class="required">*</span></label>
                <input type="text" id="phone" required>
            </div>
            <div class="form-group">
                <label for="city">Tỉnh/Thành phố <span class="required"></span></label>
                <input type="text" id="city" disabled>
            </div>
            <div class="form-group">
    <label for="district">Quận/Huyện <span class="required">*</span></label>
    <input type="text" id="district" disabled>
</div>
<div class="form-group">
    <label for="ward">Phường/Xã <span class="required"></span>*</label>
    <input type="text" id="ward" disabled>
</div>
            <div class="form-group">
                <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                <input type="text" id="address" required>
            </div>
        </form>
    </div>
    
    <div class="order-summary">
        <h2>Đơn hàng của bạn</h2>
        <p><strong>Sản phẩm:</strong> Tropical Vibes Mousse – Mousse Ổi hồng & Chanh dây - 16cm</p>
        <p><strong>Tạm tính:</strong> 485.000 ₫</p>
        <p><strong>Giao hàng:</strong> 30.000 ₫</p>
        <p><strong>Tổng:</strong> <span style="color:red; font-weight: bold;">515.000 ₫</span></p>
        <div class="payment-method">
            <p><strong>Thanh toán tiền mặt khi nhận hàng</strong></p>
        </div>
        <button id="btn-thanh-toan" class="btn-submit">Xác nhận thanh toán</button>


        <a href="trangGioHang.php" class="btn-back-cart">Quay lại giỏ hàng</a>
    </div>
</div>
<script>
    // Giả lập dữ liệu tài khoản đã đăng ký
    let userInfo = {
        name: "Nguyễn Văn A",
        phone: "0909123456",
        city: "Tp. Hồ Chí Minh",
        address: "123 Đường ABC, Quận 1"
    };

    // Tự động điền dữ liệu vào form
    document.getElementById("name").value = userInfo.name;
    document.getElementById("phone").value = userInfo.phone;
    document.getElementById("city").value = userInfo.city;
    document.getElementById("address").value = userInfo.address;

    document.getElementById("btn-thanh-toan").onclick = function() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let address = document.getElementById("address").value.trim();

    if (!name || !email || !phone || !address) {
        alert("Vui lòng điền đầy đủ thông tin trước khi thanh toán!");
        return;
    }

    // Nếu thông tin hợp lệ, chuyển hướng sang trang hoàn tất đơn hàng
    window.location.href = "hoanTatDonHang.php";
};
</script>
      <!-- testimonial section end -->
      <!-- contact section start -->
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