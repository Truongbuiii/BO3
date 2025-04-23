<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Sử dụng tên người dùng MySQL của bạn
$password = ""; // Mật khẩu MySQL của bạn
$dbname = "tiemkem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy giá trị tìm kiếm từ form
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';

// Truy vấn tìm kiếm sản phẩm theo tên, phân loại và khoảng giá
$sql = "SELECT * FROM SanPham WHERE TenSanPham LIKE '%$search%'";

if ($category) {
    $sql .= " AND MaLoai = '$category'";
}

if ($price_range) {
    list($min_price, $max_price) = explode('-', $price_range);
    $sql .= " AND DonGia BETWEEN $min_price AND $max_price";
}

$result = $conn->query($sql);

// Lấy danh sách phân loại từ bảng LoaiSanPham
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
               <a class="navbar-brand"href="index.html"><img src="/images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item active">
                        <a class="nav-link" href="/index.php">Trang chủ</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="about.html">Kem Ly</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="icecream.html">Kem Ốc Quế</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="services.html">Kem Que</a>
                     </li>
                    
                  </ul>
                  
                  <form action="search.php" method="GET" class="form-inline my-2 my-lg-0">
    <input type="text" name="search" class="form-control mr-sm-2" placeholder="Tìm theo tên sản phẩm" value="<?php echo htmlspecialchars($search); ?>" style="height: 38px;">
    
    <button type="submit" class="btn btn-outline-success my-2 my-sm-0" style="height: 38px;">
        <i class="fa fa-search" style="color: aliceblue;"></i>
    </button>
</form>
<div class="login_bt"><a href="#"><i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 150%;"></i></a><i class="bi bi-bag-heart-fill custom-icon"></i>

            </div>
        </nav>
    </div>
</div>

<!-- Search Header -->
<div class="search-header">
    <h2>Kết quả tìm kiếm:</h2>
</div>

<!-- Search Form for Category and Price Range -->
<div class="container mt-4">
    <form action="search.php" method="GET" class="form-inline justify-content-center">
        <select name="category" class="form-control mb-2 mr-sm-2">
            <option value="">-- Chọn phân loại --</option>
            <?php
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo "<option value='" . $row['MaLoai'] . "' " . ($category == $row['MaLoai'] ? 'selected' : '') . ">" . $row['TenLoai'] . "</option>";
                }
            }
            ?>
        </select>

        <select name="price_range" class="form-control mb-2 mr-sm-2" style="height: 38px;">
    <option value="">-- Chọn khoảng giá --</option>
    <option value="10000-12000" <?php echo ($price_range == '10000-12000' ? 'selected' : ''); ?>>10,000đ - 12,000đ</option>
    <option value="13000-15000" <?php echo ($price_range == '13000-15000' ? 'selected' : ''); ?>>13,000đ - 15,000đ</option>
    <option value="16000-20000" <?php echo ($price_range == '16000-20000' ? 'selected' : ''); ?>>16,000đ - 20,000đ</option>
</select>

<button type="submit" class="btn btn-outline-success mb-2" style="height: 38px;">
    <i class="fa fa-search" style="color: aliceblue;"></i>
</button>



    </form>
</div>

<!-- Display Search Results -->
<div class="container mt-4 search-results">
    <div class="row">
        <?php
        if ($result && $result->num_rows > 0) {
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
            echo '<div class="col-12">
                    <p class="no-results">Không tìm thấy sản phẩm phù hợp.</p>
                  </div>';
        }
        ?>
    </div>
</div>



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
