<?php
session_start();
?>

<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Trang chủ</title>
      
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- Font Awesome icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   </head>
   
   <body>
      <div class="header_section">
         <div class="container">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <!-- Logo -->
                <a class="navbar-brand" href="/index.php">
                    <img src="images/logo.png" alt="Logo">
                </a>

                <!-- Nút toggle menu trên mobile (hamburger menu) -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" 
                        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Nội dung menu -->
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/index.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="includes/kemLy.php">Kem ly</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="includes/kemOcQue.php">Kem ốc quế</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="includes/kemQue.php">Kem que</a>
                        </li>
                    </ul>

                    <!-- Form tìm kiếm -->
                    <form class="form-inline my-2 my-lg-0" action="includes/search.php" method="GET">
                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Tìm kiếm..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                    <!-- Icon User & Giỏ hàng -->
                    <ul class="navbar-nav ml-3">
                        <li class="nav-item d-flex align-items-center">
                            <!-- Icon người dùng -->
                            <a href="#" onclick="handleUserClick()">
                                <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                            </a>

                            <!-- Icon giỏ hàng -->
                            <a href="#" onclick="handleCartClick()">
                                <i class="bi bi-bag-heart-fill custom-icon" style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                            </a>

                            <!-- Hiển thị tên và nút đăng xuất nếu đã đăng nhập -->
                            <?php if (isset($_SESSION['username'])): ?>
                                <span style="color: #fc95c4; font-weight: bold; padding-left: 10px;">
                                    Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                                </span>
                                <a href="logout.php" class="btn btn-outline-danger ml-2">Đăng xuất</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
      </div>

      <!-- jQuery, Popper.js, Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

      <script>
          const isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;

          function handleUserClick() {
              if (isLoggedIn) {
                  window.location.href = "includes/userProfile.php"; // Chuyển tới trang thông tin người dùng
              } else {
                  window.location.href = "login.php"; // Nếu chưa đăng nhập
              }
          }

          function handleCartClick() {
              if (isLoggedIn) {
                  window.location.href = "includes/trangGioHang.php"; // Giỏ hàng nếu đã đăng nhập
              } else {
                  alert("Bạn cần đăng nhập để xem giỏ hàng!");
                  window.location.href = "login.php";
              }
          }
      </script>
   </body>
</html>
