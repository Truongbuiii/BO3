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
 html {
    scroll-behavior: smooth;
}


</style>
   </head>
   <?php require_once("kiemtradangnhap.php"); ?>


   <body>
      <div class="header_section">
         <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/index.php ">
            <img src="images/logo.png" alt="Logo">
        </a>

        <!-- Nút toggle menu trên mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nội dung menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav">

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

<!-- Đặt đoạn script bên dưới, trước </body> hoặc ở cuối file -->
<script>
    // Kiểm tra trạng thái đăng nhập từ PHP
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
            window.location.href = "includes/cart.php"; // Giỏ hàng nếu đã đăng nhập
        } else {
            alert("Bạn cần đăng nhập để xem giỏ hàng!");
            window.location.href = "login.php";
        }
    }
</script>



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
                              <h1 class="banner_taital">Kem Tươi</h1>
                           
                              <p class="banner_text">Tận hưởng từng muỗng kem mát lạnh, mềm mịn tan chảy trên đầu lưỡi. Được làm từ những nguyên liệu tươi ngon, kem mang đến hương vị ngọt ngào và sảng khoái, khiến mọi khoảnh khắc thưởng thức trở nên đặc biệt.</p>

                           <div class="started_text"><a href="#sanpham">Mua ngay</a></div>

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
            <h3 class="services_taital">Loại Kem</h3>
         </div>
      </div>
      <div class="services_section_2">
         <div class="row">
            <div class="col-md-4">
               <a href="includes/kemLy.php">
                  <div class="services_box">
                     <h5 class="tasty_text">
                        <span class="icon_img"><i class="fa-solid fa-bowl-food" style="font-size: 190%; color: #f7a8c9;"></i></span>Kem ly
                     </h5>
                     <p class="lorem_text">Ngọt ngào từng lớp, mát lạnh từng thìa!</p>
                  </div>
               </a>
            </div>
            <div class="col-md-4">
               <a href="includes/kemOcQue.php">
                  <div class="services_box">
                     <h5 class="tasty_text">
                        <span class="icon_img"><img src="images/icon-2.png"></span>Kem ốc quế
                     </h5>
                     <p class="lorem_text">Ốc quế giòn tan – hoàn hảo từng miếng!</p>
                  </div>
               </a>
            </div>
            <div class="col-md-4">
               <a href="includes/kemQue.php">
                  <div class="services_box">
                     <h5 class="tasty_text">
                        <span class="icon_img"><img src="images/icon-1.png"></span>Kem que
                     </h5>
                     <p class="lorem_text">Kem que mát lạnh trong từng cú chạm!</p>
                  </div>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>

<style>
   .services_box {
      border: 2px solid #f7a8c9;
      border-radius: 10px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
   }

   .services_box:hover {
      transform: translateY(-10px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
   }

   .tasty_text {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
   }

   .lorem_text {
      font-size: 1rem;
      color: #777;
   }

   .icon_img i, .icon_img img {
      vertical-align: middle;
   }

   .services_box a {
      text-decoration: none;
   }

   
</style>

      <!-- services section end -->

      <div class="about_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="about_img"><img src="images/about-img.png"></div>
               </div>
               <div class="col-md-6">
                  <h1 class="about_taital">Giới Thiệu Kem</h1>
                  <p class="about_text">Kem – món tráng miệng mát lạnh và thơm ngon, là sự kết hợp hoàn hảo giữa sữa, đường và các hương vị tự nhiên. Với kết cấu mềm mịn tan chảy ngay trên đầu lưỡi, kem mang đến cảm giác sảng khoái và ngọt ngào khó cưỡng.

                     Từ những hương vị cổ điển như vanilla, socola, dâu tây đến những biến tấu độc đáo như trà xanh, caramel muối, hoặc trái cây nhiệt đới, kem luôn là lựa chọn yêu thích của mọi lứa tuổi. Không chỉ là một món ăn, kem còn gắn liền với những khoảnh khắc vui vẻ và đáng nhớ trong cuộc sống.</p>
                  <div class="read_bt_1"><a href="#">Xem thêm</a></div>
               </div>
            </div>
         </div>
      </div>

   <?php require("./db/connect.php"); ?>


<div class="cream_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="cream_taital" id="sanpham">Những Loại Kem Nổi Bật </h1>
            </div>
        </div>
        <div class="row">
       <?php
// Truy vấn lấy sản phẩm bán chạy nhất
$sql = "
    SELECT sp.MaSanPham, sp.TenSanPham, sp.HinhAnh, sp.DonGia, SUM(cthd.SoLuong) AS TongSoLuong, sp.MaLoai
    FROM SanPham sp
    LEFT JOIN ChiTietHoaDon cthd ON sp.MaSanPham = cthd.MaSanPham
    WHERE sp.TinhTrang = 1  -- Only select products that are visible (TinhTrang = 1)
    GROUP BY sp.MaSanPham, sp.TenSanPham, sp.HinhAnh, sp.DonGia, sp.MaLoai
    ORDER BY sp.MaLoai, TongSoLuong DESC
";


$result = $conn->query($sql);

$sanphamByLoai = [
    'L01' => [], // Kem ốc quế
    'L02' => [], // Kem que
    'L03' => []  // Kem cốc
];

// Phân loại sản phẩm theo loại kem
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sanphamByLoai[$row['MaLoai']][] = $row;
    }
}

// Lấy 3 sản phẩm bán chạy nhất cho mỗi loại kem
$topSanPham = [];
foreach ($sanphamByLoai as $loai => $sanphams) {
    $topSanPham[$loai] = array_slice($sanphams, 0, 3);  // Chỉ lấy 3 sản phẩm bán chạy nhất
}

// Hiển thị sản phẩm
foreach ($topSanPham as $loai => $sanphams) {
    foreach ($sanphams as $row) {
        echo '<div class="col-md-4">
                <div class="cream_box">
                    <div class="cream_img">
                        <a href="includes/chitietsanpham.php?MaSanPham=' . $row["MaSanPham"] . '">
                            <img src="/images/' . $row["HinhAnh"] . '" alt="' . $row["TenSanPham"] . '">
                        </a>
                    </div>
                    <div class="price_text">' . number_format($row["DonGia"]) . 'đ</div>
                    <h6 class="strawberry_text">' . $row["TenSanPham"] . '</h6>
                    <div class="cart_bt">
                        <a href="includes/chitietsanpham.php?MaSanPham=' . $row["MaSanPham"] . '">Xem chi tiết</a>
                    </div>
                </div>
              </div>';
    }
}
?>

        </div>
    </div>
    <div class="seemore_bt"><a href="#">Xem thêm</a></div>
</div>


<?php $conn->close(); ?>
<?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
    <div class="alert alert-success text-center" style="margin-top: 10px;">
        Đăng nhập thành công!
    </div>
<?php endif; ?>



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