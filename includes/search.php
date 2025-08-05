<?php
session_start();
require(__DIR__ . "/../db/connect.php");

// Kết nối CSDL nếu cần
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "b03db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu từ form tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : '';

// Thiết lập phân trang (số sản phẩm mỗi trang là 6)
$limit = 6; // số sản phẩm mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Truy vấn đếm tổng số sản phẩm
$count_sql = "SELECT COUNT(*) AS total FROM SanPham WHERE 1";

// Điều kiện lọc
if (!empty($search)) {
    $count_sql .= " AND TenSanPham LIKE '%" . $conn->real_escape_string($search) . "%'";
}
if (!empty($category)) {
    $count_sql .= " AND MaLoai = '" . $conn->real_escape_string($category) . "'";
}
if (!empty($min_price)) {
    $count_sql .= " AND DonGia >= $min_price";
}
if (!empty($max_price)) {
    $count_sql .= " AND DonGia <= $max_price";
}

// Thực hiện truy vấn đếm tổng số sản phẩm
$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit); // Tính tổng số trang

// Truy vấn sản phẩm có phân trang
$sql = "SELECT * FROM SanPham WHERE 1";

if (!empty($search)) {
    $sql .= " AND TenSanPham LIKE '%" . $conn->real_escape_string($search) . "%'";
}
if (!empty($category)) {
    $sql .= " AND MaLoai = '" . $conn->real_escape_string($category) . "'";
}
if (!empty($min_price)) {
    $sql .= " AND DonGia >= $min_price";
}
if (!empty($max_price)) {
    $sql .= " AND DonGia <= $max_price";
}

// Thêm LIMIT cho phân trang
$sql .= " LIMIT $start, $limit";

// Thực thi truy vấn sản phẩm
$result = $conn->query($sql);

// Truy vấn danh mục
$category_sql = "SELECT * FROM LoaiSanPham";
$category_result = $conn->query($category_sql);
?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .search-header {
            text-align: center;
            margin-top: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .search-results {
            margin-top: 30px;
        }

    .product-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin: 10px;
        text-align: center;
        border-radius: 5px;
        transition: transform 0.2s;
    }
    .product-item:hover {
        transform: scale(1.05);
    }
    .product-item img {
        width: 100%;
        height: auto;
        border-radius: 5px;
    }
    .product-item .product-name {
        font-size: 18px;
        margin-top: 10px;
        font-weight: bold;
    }
    .product-item .product-price {
        font-size: 16px;
        color: #f39c12;
        margin-top: 10px;
    }
    .no-results {
        text-align: center;
        font-size: 18px;
        color: #e74c3c;
        margin-top: 30px;
    }
    /* Ẩn nút tăng/giảm trong input type=number */


/* Ẩn nút tăng/giảm trong input type=number */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}

/* Cải thiện kiểu dáng của form */
/* Cải thiện kiểu dáng của form */
form {
    max-width: 900px;
    margin: 0 auto;
}

/* Tiêu đề tìm kiếm */
/* Cải thiện kiểu dáng của form */
form {
    max-width: 900px;
    margin: 0 auto;
}

/* Tiêu đề tìm kiếm */
.search-header h2 {
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

/* Cải thiện tiêu đề (label) */
.form-label {
    font-weight: 600;
    font-size: 1.1rem;
    color: #495057;
   
    display: block; /* Đảm bảo labels nằm bên trên input */
    margin-bottom: 5px;
}

/* Cải thiện các input */
input.form-control, select.form-control {
    border-radius: 0.375rem; /* Bo tròn góc */
    padding: 0.5rem;  /* Padding cho input */
    font-size: 1rem;  /* Kích thước font */
    width: 100%; /* Chiều rộng input chiếm 100% của cột */
}

/* Cải thiện khoảng cách giữa các phần tử */
.g-2 {
    gap: 1.5rem;
}

/* Giảm khoảng cách giữa các input và align chúng vào một hàng */
.d-flex {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem; /* Giữa các input có khoảng cách */
}

.d-flex > div {
    flex: 1; /* Cột input chiếm không gian đều */
}

/* Cải thiện nút tìm kiếm */
button[type="submit"] {
    font-size: 0,1rem;
    padding: 0.5rem;
    background-color: #28a745;  /* Màu xanh nút */
    color: white;
    border: none;
    border-radius: 0.375rem;  /* Bo tròn góc */
    transition: background-color 0.3s ease;
    width: 20%;  /* Đảm bảo nút tìm kiếm chiếm hết chiều rộng */
}

button[type="submit"]:hover {
    background-color: #218838;  /* Màu nút khi hover */
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    padding: 8px 16px;
    margin: 0 5px;
    text-decoration: none;
   color:rgb(249, 245, 247);
   background-color: #fc95c4;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.pagination a:hover {
    background-color:white;
    color: #fc95c4;
}

.pagination .active {
    background-color:#fc95c4;
    color: #fff;
  
    font-weight: bold;
}

.pagination a:disabled {
    background-color: #e9ecef;
    color: #6c757d;
    pointer-events: none;
    border-color: #ddd;
}

.pagination a[aria-disabled="true"] {
    pointer-events: none;
}



</style>

<!-- basic -->
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- mobile metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1">


<!-- site metas -->


  <title>Icecream</title>
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   </head>
   <body>
     <div class="header_section header_bg">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a class="nav-link" href="/index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="kemLy.php">Kem ly</a></li>
                <li class="nav-item"><a class="nav-link" href="kemOcQue.php">Kem ốc quế</a></li>
                <li class="nav-item"><a class="nav-link" href="kemQue.php">Kem que</a></li>
            </ul>
            <form class="form-inline" action="search.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Tìm kiếm...">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <ul class="navbar-nav ml-3">
                <li class="nav-item d-flex align-items-center">
                    <a href="#" onclick="handleUserClick()">
                        <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%; padding-left:10px;"></i>
                    </a>
                    <a href="#" onclick="handleCartClick()">
                        <i class="bi bi-bag-heart-fill" style="color:#fc95c4; font-size: 220%; padding-left:10px;"></i>
                    </a>
                    <?php if (isset($_SESSION['username'])): ?>
                        <span style="color: #fc95c4; font-weight: bold; padding-left: 10px;">
                            Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                        </span>
                       
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</div>


</div>
<!-- Search Header -->
<div class="search-header">
    <h2>Kết quả tìm kiếm:</h2>
</div>

<div class="container mt-4">
    <form action="search.php" method="GET" class="d-flex justify-content-between align-items-end gap-3">
    
        <!-- Phân loại -->
        <div class="d-flex flex-column w-100">
            <label for="category" class="form-label">Phân loại</label>
            <select name="category" id="category" class="form-control">
                <option value="">-- Chọn phân loại --</option>
                <?php
                if ($category_result->num_rows > 0) {
                    while ($row = $category_result->fetch_assoc()) {
                        echo "<option value='" . $row['MaLoai'] . "' " . ($category == $row['MaLoai'] ? 'selected' : '') . ">" . $row['TenLoai'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Giá từ -->
        <div class="d-flex flex-column w-100">
            <label for="min_price" class="form-label">Giá từ</label>
            <input type="number" name="min_price" class="form-control"
                   placeholder="Giá từ" min="0"
                   value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
        </div>

        <!-- Giá đến -->
        <div class="d-flex flex-column w-100">
            <label for="max_price" class="form-label">Đến</label>
            <input type="number" name="max_price" class="form-control"
                   placeholder="Đến" min="0"
                   value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
        </div>

        <!-- Nút tìm -->
        <div class="d-flex flex-column w-100">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-search me-1"></i>
            </button>
        </div>

    </form>
</div>

<!-- Display Search Results -->

<div class="container mt-4 search-results">
    <div class="row">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Sử dụng htmlspecialchars để bảo vệ dữ liệu
                $productName = htmlspecialchars($row["TenSanPham"]);
                $productPrice = number_format($row["DonGia"], 0, ',', '.');
                $productImage = htmlspecialchars($row["HinhAnh"]);
                $productLink = "chitietsanpham.php?MaSanPham=" . $row["MaSanPham"];

                echo '<div class="col-md-4">
                    <div class="cream_box">
                        <div class="cream_img">
                            <a href="' . $productLink . '">
                                <img src="/images/' . $productImage . '" alt="' . $productName . '">
                            </a>
                        </div>
                        <div class="price_text">' . $productPrice . 'đ</div>
                        <h6 class="strawberry_text">' . $productName . '</h6>
                        <div class="cart_bt">
                            <a href="' . $productLink . '">Xem chi tiết</a>
                        </div>
                    </div>
                  </div>';
            }
        } else {
            echo '<div class="col-12">
                    <p class="no-results">Không tìm thấy sản phẩm phù hợp.</p>
                  </div>';
        }
        ?>
       

    </div>
     <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?search=<?= $search ?>&category=<?= $category ?>&min_price=<?= $min_price ?>&max_price=<?= $max_price ?>&page=<?= $page - 1 ?>">&laquo; Trang trước</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?search=<?= $search ?>&category=<?= $category ?>&min_price=<?= $min_price ?>&max_price=<?= $max_price ?>&page=<?= $i ?>" 
           class="<?= ($i == $page) ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?search=<?= $search ?>&category=<?= $category ?>&min_price=<?= $min_price ?>&max_price=<?= $max_price ?>&page=<?= $page + 1 ?>">Trang sau &raquo;</a>
    <?php endif; ?>
</div>
</div>
<!-- contact section start -->
<div class="contact_section layout_padding" style="background-color: #343a40; padding: 50px 0; color: white;">
   <div class="container">
      <div class="row">
         <!-- Contact Info -->
         <div class="col-md-6 mb-4">
            <h2 class="text-light mb-4">Liên Hệ Với Chúng Tôi</h2>
            <p class="text-muted">Chúng tôi luôn sẵn sàng phục vụ và giải đáp thắc mắc của bạn. Hãy liên lạc ngay với chúng tôi qua các phương thức dưới đây:</p>
            <ul class="list-unstyled">
               <li class="mb-3">
                  <a href="#" class="text-decoration-none text-white hover-effect">
                     <i class="fa fa-map-marker-alt me-3" aria-hidden="true" style="color: #ff6f61;"></i>
                     <span class="font-weight-bold">Địa chỉ:</span> 1234 Cây Kem, Phường 1, Quận 2, TP. Hồ Chí Minh, Trái Đất
                  </a>
               </li>
               <li class="mb-3">
                  <a href="tel:+0123456789" class="text-decoration-none text-white hover-effect">
                     <i class="fa fa-phone-alt me-3" aria-hidden="true" style="color: #ff6f61;"></i>
                     <span class="font-weight-bold">Hotline:</span> +01 2345 6789
                  </a>
               </li>
               <li class="mb-3">
                  <a href="mailto:BeYeukem1234@gmail.com" class="text-decoration-none text-white hover-effect">
                     <i class="fa fa-envelope me-3" aria-hidden="true" style="color: #ff6f61;"></i>
                     <span class="font-weight-bold">Email:</span> BeYeukem1234@gmail.com
                  </a>
               </li>
            </ul>
         </div>

         <!-- Social Media -->
         <div class="col-md-6 mb-4">
            <h2 class="text-light mb-4">Kết Nối Với Chúng Tôi</h2>
            <p class="text-muted">Theo dõi chúng tôi trên các mạng xã hội để cập nhật thông tin mới nhất:</p>
            <ul class="list-inline">
               <li class="list-inline-item">
                  <a href="#" class="text-white social-icon hover-effect">
                     <i class="fab fa-facebook-f"></i>
                  </a>
               </li>
               <li class="list-inline-item">
                  <a href="#" class="text-white social-icon hover-effect">
                     <i class="fab fa-twitter"></i>
                  </a>
               </li>
               <li class="list-inline-item">
                  <a href="#" class="text-white social-icon hover-effect">
                     <i class="fab fa-linkedin-in"></i>
                  </a>
               </li>
               <li class="list-inline-item">
                  <a href="#" class="text-white social-icon hover-effect">
                     <i class="fab fa-instagram"></i>
                  </a>
               </li>
            </ul>
         </div>
      </div>

      <!-- Footer -->
      <div class="text-center mt-5">
         <p class="mb-0" style="font-size: 14px; color: #6c757d;">© 2025 TiemKemF4. Tất cả các quyền được bảo lưu.</p>
         <p style="font-size: 16px; color: #6c757d;">Thiết kế bởi <strong>TiemKemF4</strong> – Mang vị ngọt đến mọi nhà 🍦</p>
      </div>
   </div>
</div>
<!-- contact section end -->

<!-- CSS for Hover Effect -->
<style>
   .hover-effect:hover {
      color: #ff6f61;
      transition: all 0.3s ease;
   }

   .social-icon:hover i {
      color: #ff6f61;
   }

   .social-icon i {
      font-size: 25px;
      transition: color 0.3s ease;
   }

   .text-light {
      color: #f8f9fa !important;
   }

   .text-muted {
      color: #adb5bd;
   }
</style>

     </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
 <script src="../js/main1.js"></script>
<!-- Script điều hướng -->

<!-- CSS phân trang -->
<style>
.pastel-pagination .page-link {
    color: #d63384;
    background-color: #fff0f5;
    border: 1px solid #f9c6d1;
    border-radius: 8px;
    margin: 0 4px;
    font-weight: 500;
}
.pastel-pagination .page-link:hover {
    background-color: #f9c6d1;
    color: white;
}
.pastel-pagination .page-item.active .page-link {
    background-color: #fc95c4;
    color: white;
}
.pastel-pagination .page-item.disabled .page-link {
    background-color: #fce4ec;
    color: #d63384;
}
</style>




<!-- Bootstrap JS -->

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

<?php $conn->close(); ?>  
