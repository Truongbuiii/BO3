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

    <style>
    .banner_taital {
        font-size: 40px;
        font-weight: bold;
        color: rgba(0, 0, 0, 0.95);
        /* Màu sắc nổi bật */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .banner_text {
        font-size: 18px;
        color: black;
        font-weight: 500;
        margin-bottom: 8px;
    }
    </style>
    </head>
    <body>
        <div class="header_section">
           <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="Logo">
        </a>

        <!-- Nút toggle menu trên mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nội dung menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"> 
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="icecream-cone.html">Kem ốc quế</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="icecream-cup.html">Kem ly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="icecream-stick.html">Kem que</a>
                </li>
            </ul>

            <!-- Form tìm kiếm -->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <!-- Icon User & Giỏ hàng -->
            <ul class="navbar-nav ml-3">
                <li class="nav-item">
                    <a href="#"><i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%;padding-left:10px; padding-top:12px"></i></a>
                </li>
                <li class="nav-item ml-3">
                    <a href="includes/trangGioHang.php">
                        <i class="bi bi-bag-heart-fill custom-icon"></i>
                    </a>
                </li>
            </ul>
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
                            <h2 class="banner_taital" style="font-family: 'Poppins', sans-serif;">Tiệm cây kem</h2>
                            <p class="banner_text">Mát lạnh từng muỗng, ngọt ngào từng khoảnh khắc</p>
                            <p class="banner_text">Hương vị tuyệt vời, yêu ngay từ lần đầu tiên</p>
                            <p class="banner_text">Ngọt mát tự nhiên – Đánh thức vị giác</p>
                            <div class="started_text"><a href="#">Mua Hàng ngay</a></div>

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
                            <p class="lorem_text">Ngọt ngào từng lớp, mát lạnh từng thìa!</p>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="icecream.html">
                        <div class="services_box">
                            <h5 class="tasty_text"><span class="icon_img"><img src="images/icon-2.png"></span>Kem ốc quế</h5>
                            <p class="lorem_text">Ốc quế giòn tan – hoàn hảo từng miếng!</p>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="icecream.html">
                        <div class="services_box">
                            <h5 class="tasty_text"><span class="icon_img"><img src="images/icon-1.png"></span>Kem que</h5>
                            <p class="lorem_text">Kem que mát lạnh trong từng cú chạm!</p>
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
                
                </div>
            </div>
            <div class="seemore_bt"><a href="#">See More</a></div>
        </div>
    </div>



        <!-- testimonial section start -->
        <div class="testimonial_section layout_padding">
            <div class="container">
                <div class="row">
                <div class="col-md-12">
                    <h1 class="testimonial_taital">Testimonial</h1>
                </div>
                </div>
                <div class="testimonial_section_2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="testimonial_box">
                            <div id="main_slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="testimonial_text">tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint</p>
                                    <h4 class="client_name">Marri Fen</h4>
                                    <div class="client_img"><img src="images/client-img.png"></div>
                                </div>
                                <div class="carousel-item">
                                    <p class="testimonial_text">tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint</p>
                                    <h4 class="client_name">Marri Fen</h4>
                                    <div class="client_img"><img src="images/client-img.png"></div>
                                </div>
                                <div class="carousel-item">
                                    <p class="testimonial_text">tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint</p>
                                    <h4 class="client_name">Marri Fen</h4>
                                    <div class="client_img"><img src="images/client-img.png"></div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- testimonial section end -->
        <!-- contact section start -->
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