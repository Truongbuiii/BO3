<?php
session_start(); // Bắt đầu phiên làm việc

require(__DIR__ . "/../db/connect.php");

// Kết nối MySQL (nếu chưa được trong file connect.php)
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

// Truy vấn chính
$sql = "SELECT * FROM SanPham WHERE 1";

// Thêm điều kiện tìm kiếm theo tên
if (!empty($search)) {
    $sql .= " AND TenSanPham LIKE '%" . $conn->real_escape_string($search) . "%'";
}

// Thêm điều kiện phân loại
if (!empty($category)) {
    $sql .= " AND MaLoai = '" . $conn->real_escape_string($category) . "'";
}

// Thêm điều kiện giá
if (!empty($min_price)) {
    $sql .= " AND DonGia >= $min_price";
}
if (!empty($max_price)) {
    $sql .= " AND DonGia <= $max_price";
}

// Thực thi truy vấn
$result = $conn->query($sql);

// Truy vấn lấy danh sách phân loại
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
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}

/* Cải thiện kiểu dáng của form */
form {
    max-width: 900px;
    margin: 0 auto;
}

/* Tùy chỉnh tiêu đề (label) */
.form-label {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 5px;
    color: #495057;
}

/* Cải thiện các input */
input.form-control, select.form-control {
    border-radius: 0.375rem; /* Bo tròn góc */
    padding: 0.5rem;  /* Padding cho input */
    font-size: 1rem;  /* Kích thước font */
}

/* Cải thiện nút tìm kiếm */
button[type="submit"] {
    font-size: 1rem;
    padding: 0.5rem;
    background-color: #28a745;  /* Màu xanh nút */
    color: white;
    border: none;
    border-radius: 0.375rem;  /* Bo tròn góc */
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #218838;  /* Màu nút khi hover */
}

/* Cải thiện các khoảng cách giữa các phần tử */
.g-3 {
    gap: 1.5rem;
}

/* Giảm khoảng cách giữa các input */
.col-md-2 input, .col-md-3 select {
    width: 100%;
}

/* Cải thiện khoảng cách trong các input */
input.form-control, select.form-control {
    padding-left: 1rem;  /* Padding thêm vào bên trái */
}

/* Cải thiện kiểu của tiêu đề */
h5 {
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
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
    <form action="search.php" method="GET" class="form-inline justify-content-center flex-wrap gap-2">
        <select name="category" class="form-control mb-2 mr-sm-2">
             <label for="category" class="form-label">Phân loại</label>
            <option value="">-- Chọn phân loại --</option>
            <?php
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo "<option value='" . $row['MaLoai'] . "' " . ($category == $row['MaLoai'] ? 'selected' : '') . ">" . $row['TenLoai'] . "</option>";
                }
            }
            ?>
        </select>

        <!-- Giá từ -->
          <label for="min_price" class="form-label">Giá từ (đ)</label>
        <input type="number" name="min_price" class="form-control mb-2 mr-sm-2" placeholder="Giá từ" min="0"
               value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">

        <!-- Giá đến -->
          <label for="max_price" class="form-label">Đến (đ)</label>
        <input type="number" name="max_price" class="form-control mb-2 mr-sm-2" placeholder="Đến" min="0"
               value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">

        <button type="submit" class="btn btn-success mb-2">
            <i class="fa fa-search me-1"></i>
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
