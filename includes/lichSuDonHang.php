

<!-- Nội dung chính -->
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
/* Tạo hiệu ứng cho bảng lịch sử giao dịch */
.table {
    border-radius: 12px; /* Bo góc bảng */
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Bóng đổ nhẹ để tạo cảm giác mềm mại */
    background-color: white;
    margin-top: 30px;
    margin-bottom: 40px;
}

/* Cải thiện màu nền cho tiêu đề bảng */
.table th {
    background-color: #f1f1f1;
    color: #333;
    font-weight: bold;
    text-align: center;
    padding: 15px 10px;
}

/* Cải thiện bảng con */
.table td {
    text-align: center;
    vertical-align: middle;
    padding: 12px 10px;
    font-size: 14px;
}

/* Hiệu ứng hover trên các dòng */
.table tbody tr:hover {
    background-color: #f7f7f7; /* Thay đổi màu nền khi hover */
    transition: background-color 0.3s ease;
}

/* Tăng cường hình ảnh sản phẩm */
.table img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Cải thiện nút "Xem chi tiết" */
.btn-cancel {
    background-color: #4CAF50; /* Màu xanh lá */
    color: white;
    padding: 8px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-cancel:hover {
    background-color: #45a049; /* Xanh lá đậm khi hover */
}

/* Cải thiện các trạng thái */
.badge {
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 12px;
}

.bg-success {
    background-color: #28a745; /* Xanh lá */
}

.bg-danger {
    background-color: #dc3545; /* Đỏ */
}

.bg-warning {
    background-color: #ffc107; /* Vàng */
}
.don-hang-container {
    width: 100%;
    max-width: none; /* không giới hạn chiều ngang */
    margin: 0;
    padding: 90px 5%;
    background-color: white;
    border-radius: 0; /* bỏ bo góc nếu cần che kín */
    box-shadow: none;
    z-index: 999;
    position: relative;
}



.table-responsive {
    max-width: 100%;
    overflow-x: auto;
}

.table {
    width: 100%;
    min-width: 1000px; /* 👈 Làm bảng to hơn */
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: white;
}

.table th {
    background-color: #f1f1f1;
    color: #333;
    font-weight: bold;
    text-align: center;
    padding: 15px;
    font-size: 16px;
}

.table td {
    text-align: center;
    vertical-align: middle;
    padding: 12px;
    font-size: 15px;
}

.table tbody tr:hover {
    background-color: #f9f9f9;
    transition: background-color 0.3s ease;
}

.table img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Nút "Xem chi tiết" */
.btn-cancel {
    background-color: #4CAF50;
    color: white;
    padding: 8px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-cancel:hover {
    background-color: #388e3c;
}

.badge {
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 12px;
    color: white;
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


    
         <div class="container don-hang-container">
    <h2 class="text-center">Lịch sử Giao Dịch</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Thời gian đặt</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="order-body">
                <tr>
                    <td><img src="/images/kemLyDau.jpg" alt="Kem Dâu"></td>
                    <td>Kem Dâu tươi mát</td>
                    <td>50.000đ</td>
                    <td>07/04/2025 19:25</td>
                    <td><span class="badge bg-success">Thành công</span></td>
                    <td><button class="btn btn-cancel">Xem chi tiết</button></td>
                </tr>
                <tr>
                    <td><img src="/images/kemQueSocola.jpg" alt="Kem Socola"></td>
                    <td>Kem Que Socola</td>
                    <td>30.000đ</td>
                    <td>05/04/2025 15:42</td>
                    <td><span class="badge bg-danger">Đã hủy</span></td>
                    <td><button class="btn btn-cancel">Xem chi tiết</button></td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
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
      <!-- javascript --> 
   </body>
</html>

</body>
</html>
