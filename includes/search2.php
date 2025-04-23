<?php
require("../db/connect.php");

if (isset($_GET['search'])) {
    // Sanitize user input to prevent SQL injection
    $keyword = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM SanPham WHERE TenSanPham LIKE '%$keyword%'";
    $result = $conn->query($sql);
}
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
                  
     
      
    <div class="container">
        <!-- Search Results Header -->
        <?php if (isset($keyword)): ?>
            <h2 class="search-header">Kết quả tìm kiếm cho: <b><?php echo htmlspecialchars($keyword); ?></b></h2>
        <?php endif; ?>

        <!          </div>
            </nav>
         </div>
      </div>
-- Display search results -->
        <div class="search-results">
            <div class="row">
                <?php
                if (isset($result) && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4">
                                <div class="product-item">
                                    <a href="includes/chitietsanpham.php?MaSanPham=' . $row["MaSanPham"] . '">
                                        <img src="/images/' . $row["HinhAnh"] . '" alt="' . $row["TenSanPham"] . '">
                                    </a>
                                    <p class="product-name">' . $row["TenSanPham"] . '</p>
                                    <p class="product-price">' . number_format($row["DonGia"]) . 'đ</p>
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
    </div>

    <!-- Optional footer or other sections -->
    <footer class="footer-section text-center mt-5">
        <p>© 2025 All Rights Reserved. Your Company</p>
    </footer>

    <!-- Link to Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
