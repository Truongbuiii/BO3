<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Giả sử dữ liệu người dùng đã được lấy từ database
$userData = [
    'name' => $_SESSION['username'],
    'email' => 'example@email.com',
    'dob' => '2000-01-01',
    'address' => '123 Đường ABC, Quận XYZ'
];
?>

<!DOCTYPE html>
<html lang="vi">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Đăng Nhập</title>
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
      <link rel="icon" href="/images/fevicon.png" type="image/gif"/>
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   </head>
   <body>
    <div class="header_section header_bg">
        <div class="container">
           <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <a class="navbar-brand" href="index.html">
                 <img src="/images/logo.png" alt="Logo">
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                       <a class="nav-link" href="index.html">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="icecream.html">Kem ly</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="icecream.html">Kem ốc quế</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="icecream.html">Kem que</a>
                    </li>
                 </ul>
     
                 <!-- Thanh tìm kiếm -->
                 <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                       <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                 </form>
     
                 <!-- Icon đăng nhập & giỏ hàng -->
                 <ul class="navbar-nav ml-3 d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">
                            <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 150%;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.html">
                            <i class="bi bi-bag-heart-fill custom-icon" style="font-size: 150%; color:#fc95c4;"></i>
                        </a>
                    </li>
                </ul>
                
              </div>
           </nav>
        </div>
     </div>
     
     <div class="profile-container">
        <div class="profile-wrapper">
            <!-- Cột 1: Sidebar (Menu) -->
            <div class="profile-sidebar">
                <i class="fa-solid fa-user-circle profile-icon"></i>
                <h2 class="profile-name" id="profile-name"><?php echo $userData['name']; ?></h2>
                <ul class="profile-menu">
                    <li class="menu-item active" data-target="info-section">Thông tin cá nhân</li>
                    <li class="menu-item" data-target="order-history-section">Lịch sử đơn hàng</li>
                    <li class="menu-item" data-target="logout-section">Đăng xuất</li>
                </ul>
            </div>
    
            <!-- Cột 2: Hiển thị nội dung -->
            <div class="profile-content">
                <div id="info-section" class="content-section">
                    <h3>Thông Tin Cá Nhân</h3>
                    <p>Email: <span id="profile-email"><?php echo $userData['email']; ?></span></p>
                    <p>Ngày sinh: <span id="profile-dob"><?php echo $userData['dob']; ?></span></p>
                    <p>Địa chỉ: <span id="profile-address"><?php echo $userData['address']; ?></span></p>
                    <button class="edit-btn">Chỉnh sửa thông tin</button>
                </div>
                <div id="order-history-section" class="content-section hidden">
                    <h3>Lịch sử đơn hàng</h3>
                    <ul>
                        <li>Đơn hàng #001 - Đã giao</li>
                        <li>Đơn hàng #002 - Đang xử lý</li>
                        <li>Đơn hàng #003 - Đã hủy</li>
                    </ul>
                </div>
                <div id="logout-section" class="content-section hidden">
                <h3>Đăng xuất</h3>
                <a href="includes/logout.php" class="logout-btn" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?');">Xác nhận đăng xuất</a>


</div>

            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let menuItems = document.querySelectorAll(".menu-item");
        let contentSections = document.querySelectorAll(".content-section");

        menuItems.forEach(item => {
            item.addEventListener("click", function() {
                // Remove active class from all menu items
                menuItems.forEach(i => i.classList.remove("active"));
                this.classList.add("active");

                // Hide all content sections
                contentSections.forEach(section => section.classList.add("hidden"));

                // Show the corresponding content section
                let targetId = this.getAttribute("data-target");
                document.getElementById(targetId).classList.remove("hidden");
            });
        });
    });
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
