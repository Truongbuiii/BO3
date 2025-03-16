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
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
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
      <div class="header_section">
         <div class="container">
          

                     
                  <nav class="navbar navbar-expand-lg navbar-light bg-light">
                     <a class="navbar-brand"href="index.html"><img src="images/logo.png"></a>
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                     </button>
                  
                     <div class="collapse navbar-collapse d-flex justify-content-between align-items-center" id="navbarNav">
                        <ul class="navbar-nav">
                           <li class="nav-item active">
                              <a class="nav-link" href="index.php">Trang chủ</a>
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
                  
                        <!-- Thanh tìm kiếm -->
                        <form class="form-inline d-flex align-items-center">
                           <input class="form-control mr-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                           <button class="btn btn-outline-success" type="submit">
                              <i class="fa-solid fa-magnifying-glass"></i>
                           </button>
                        </form>
                  
                        <!-- Icon tài khoản, giỏ hàng -->
                        <div class="d-flex align-items-center">
                           <a href="#" class="mr-3">
                              <i class="fa-solid fa-user-large" style="color: pink; font-size: 200%;"></i>
                           </a>
                           <a href="trangiohang.html" class="position-relative">
                              <i class="bi bi-cart-fill custom-icon" style="font-size: 200%;"></i>
                              <span id="cart-count" class="badge badge-pill badge-danger position-absolute" style="top: -5px; right: -10px;">0</span>
                           </a>
                        </div>
                     </div>
                  </nav>
                  
                  </form>
               </div>
            </nav>
         </div>
         <!-- banner section start --> 
         <div class="banner_section layout_padding">
            <div class="container">
               <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <div class="row">
                           <div class="col-sm-6">
                              <h1 class="banner_taital">Ice Cream</h1>
                              <p class="banner_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem</p>
                              <div class="started_text"><a href="#">Order Now</a></div>
                           </div>
                           <div class="col-sm-6">
                              <div class="banner_img"><img src="images/banner-img.png"></div>
                           </div>
                        </div>
                     </div>  
                  </div>
               </div>
      </div>

      <!-- services section start -->
      <div class="services_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1 class="services_taital">Our Ice Cream Services</h1>
               </div>
            </div>
            <div class="services_section_2">
               <div class="row">
                  <div class="col-md-4">
                     <a href="icecream.html">
                     <div class="services_box">
                        <h5 class="tasty_text"><span class="icon_img"><i class="fa-solid fa-bowl-food" style="font-size: 190%; color: #f7a8c9;"></i></span>Kem ly</h5>
                        <p class="lorem_text">commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fat </p>
                     </div>
                     </a>
                  </div>
                  <div class="col-md-4">
                     <a href="icecream.html">
                     <div class="services_box">
                        <h5 class="tasty_text"><span class="icon_img"><img src="images/icon-2.png"></span>Kem ốc quế</h5>
                        <p class="lorem_text">commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fat </p>
                     </div>
                     </a>
                  </div>
                  <div class="col-md-4">
                     <a href="icecream.html">
                     <div class="services_box">
                        <h5 class="tasty_text"><span class="icon_img"><img src="images/icon-1.png"></span>Kem que</h5>
                        <p class="lorem_text">commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fat </p>
                     </div>
                     </a>
                  </div>
               </div>
            </div>
   
         </div>
      </div>
      <!-- services section end -->

      <div class="about_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="about_img"><img src="images/about-img.png"></div>
               </div>
               <div class="col-md-6">
                  <h1 class="about_taital">About Icecream</h1>
                  <p class="about_text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore euconsectetur adipiscing esequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu</p>
                  <div class="read_bt_1"><a href="#">Read More</a></div>
               </div>
            </div>
         </div>
      </div>

      <div class="cream_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1 class="cream_taital">Our Featured Ice Cream</h1>
                  <p class="cream_text">tempor incididunt ut labore et dolore magna aliqua</p>
               </div>
            </div>
            <div class="cream_section_2">
               <div class="row">
                  <div class="col-md-4">
                     <div class="cream_box">
                        <div class="cream_img"><img src="images/img-1.png"></div>
                        <div class="price_text">$10</div>
                        <h6 class="strawberry_text">Strawberry Ice Cream</h6>
                        <div class="cart_bt"><a href="#">Add To Cart</a></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box">
                        <div class="cream_img"><img src="images/img-2.png"></div>
                        <div class="price_text">$10</div>
                        <h6 class="strawberry_text">Strawberry Ice Cream</h6>
                        <div class="cart_bt"><a href="#">Add To Cart</a></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box">
                        <div class="cream_img"><img src="images/img-1.png"></div>
                        <div class="price_text">$10</div>
                        <h6 class="strawberry_text">Strawberry Ice Cream</h6>
                        <div class="cart_bt"><a href="#">Add To Cart</a></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="cream_section_2">
               <div class="row">
                  <div class="col-md-4">
                     <div class="cream_box">
                        <div class="cream_img"><img src="images/img-3.png"></div>
                        <div class="price_text">$10</div>
                        <h6 class="strawberry_text">Strawberry Ice Cream</h6>
                        <div class="cart_bt"><a href="#">Add To Cart</a></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box">
                        <div class="cream_img"><img src="images/img-4.png"></div>
                        <div class="price_text">$10</div>
                        <h6 class="strawberry_text">Strawberry Ice Cream</h6>
                        <div class="cart_bt"><a href="#">Add To Cart</a></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box">
                        <div class="cream_img"><img src="images/img-5.png"></div>
                        <div class="price_text">$10</div>
                        <h6 class="strawberry_text">Strawberry Ice Cream</h6>
                        <div class="cart_bt"><a href="#">Add To Cart</a></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="seemore_bt"><a href="#">See More</a></div>
         </div>
      </div>

     
      <!-- contact section start -->
      <div class="contact_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  </div>
               </div>
               <div class="col-md-8">
                  <div class="location_text">
                     <ul>
                        <li>
                           <a href="#">
                           <span class="padding_left_10 active"><i class="fa fa-map-marker" aria-hidden="true"></i></span>1234 Cây kem ,Phường 1, Quận 2, Thành Phố Hồ Chí Minh, Trái Đất.</a>
                        </li>
                        <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>Call : +01 23456789
                           </a>
                        </li>
                        <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>Email : BeYeukem1234@gmail.com
                           </a>
                        </li>
                     </ul>
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
               </div>
            </div>
         </div>
      
      <!-- contact section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">2020 All Rights Reserved. Design by <a href="https://html.design">Free Html Templates</a> Distribution by <a href="https://themewagon.com">ThemeWagon</a></p>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
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