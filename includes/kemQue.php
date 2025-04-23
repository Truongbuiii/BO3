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
      <title>Kem Ly</title>
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


   </head>
   

   <body>
    
      <div class="header_section header_bg">
         <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand"href="/index.php"><img src="/images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">

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
      <div class="cream_section layout_padding">
         <div class="container">
            <div class="row">
                <?php require("..\db\connect.php"); ?>

<div class="cream_section layout_padding">
    <div class="container">
        <div class="row">
           
        </div>
        <div class="cream_section_2">
            <div class="row">
                <?php
               // Truy vấn sản phẩm có MaLoai = 'L02' 
$sql = "SELECT * FROM SanPham WHERE MaLoai = 'L02'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4">
                <div class="cream_box">
                    <div class="cream_img">
                        <a href="chitietsanpham.php?MaSanPham=' . $row["MaSanPham"] . '">
                            <img src="/images/' . $row["HinhAnh"] . '" alt="' . $row["TenSanPham"] . '">
                        </a>
                    </div>
                    <div class="price_text">' . number_format($row["DonGia"]) . 'đ</div>
                    <h6 class="strawberry_text">' . $row["TenSanPham"] . '</h6>
                    <div class="cart_bt">
                        <a href="chitietsanpham.php?MaSanPham=' . $row["MaSanPham"] . '">Xem chi tiết</a>
                    </div>
                </div>
              </div>';
    }
} else {
    echo "<p>Không có sản phẩm nào.</p>";
}

?>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>

            </div></div></div></div></body>     

 
    

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