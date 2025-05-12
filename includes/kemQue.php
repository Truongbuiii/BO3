<?php
session_start(); // Khởi tạo session
require_once __DIR__ . '/../kiemtradangnhap.php';
require(__DIR__ . "/../db/connect.php");

// Số sản phẩm mỗi trang
$productsPerPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $productsPerPage;

// Tổng số sản phẩm
$sqlCount = "SELECT COUNT(*) AS total FROM SanPham WHERE TinhTrang = 1 AND MaLoai = 'L02'";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalProducts = $rowCount['total'];
$totalPages = ceil($totalProducts / $productsPerPage);

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM SanPham WHERE TinhTrang = 1 AND MaLoai = 'L02' LIMIT $offset, $productsPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kem Que</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<!-- Header + Navbar -->
<div class="header_section header_bg">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/index.php"><img src="/images/logo.png"></a>
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
                            <a href="index.php" class="btn btn-outline-danger ml-2">Đăng xuất</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<!-- Danh sách sản phẩm -->
<div class="cream_section layout_padding">
    <div class="container">
        <div class="row">
            <?php
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

<!-- Phân trang -->
<div class="pagination-container" style="margin-top: 40px;">
    <nav>
        <ul class="pagination justify-content-center pastel-pagination">
            <?php
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="kemQue.php?page=' . ($page - 1) . '">Trước</a></li>';
            } else {
                echo '<li class="page-item disabled"><span class="page-link">Trước</span></li>';
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $page) {
                    echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="kemQue.php?page=' . $i . '">' . $i . '</a></li>';
                }
            }

            if ($page < $totalPages) {
                echo '<li class="page-item"><a class="page-link" href="kemQue.php?page=' . ($page + 1) . '">Sau</a></li>';
            } else {
                echo '<li class="page-item disabled"><span class="page-link">Sau</span></li>';
            }
            ?>
        </ul>
    </nav>
</div>

<!-- Liên hệ -->
<div class="contact_section layout_padding">
    
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

<!-- Script điều hướng -->
<script>
    const isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
    function handleUserClick() {
        if (isLoggedIn) {
            window.location.href = "user.php";
        } else {
            window.location.href = "login.php";
        }
    }

    function handleCartClick() {
        if (isLoggedIn) {
            window.location.href = "trangGioHang.php";
        } else {
            alert("Bạn cần đăng nhập để xem giỏ hàng!");
            window.location.href = "login.php";
        }
    }
</script>

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

</body>
</html>

<?php $conn->close(); ?>
