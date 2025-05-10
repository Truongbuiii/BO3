<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "b03db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy thông tin người dùng từ CSDL
$username = $_SESSION['username'];
$sql = "SELECT * FROM NguoiDung WHERE TenNguoiDung = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
// Xử lý khi người dùng cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $phuongxa = $_POST['phuongxa'];
    $quanhuyen = $_POST['quanhuyen'];
    $tptinh = $_POST['tptinh'];

    $updateSql = "UPDATE NguoiDung SET Email=?, SoDienThoai=?, DiaChiCuThe=?, PhuongXa=?, QuanHuyen=?, TPTinh=? WHERE TenNguoiDung=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssssss", $email, $sdt, $diachi, $phuongxa, $quanhuyen, $tptinh, $username);

    if ($stmt->execute()) {
        // Cập nhật lại thông tin mới sau khi thành công
        $sql = "SELECT * FROM NguoiDung WHERE TenNguoiDung = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        echo "<script>alert('Cập nhật thành công!');</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ cá nhân</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .profile-container { padding: 50px; display: flex; justify-content: center; }
        .profile-wrapper { display: flex; width: 100%; max-width: 1000px; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden; }
        .profile-sidebar { width: 250px; background: #fcddec; padding: 30px; text-align: center; }
        .profile-icon { font-size: 80px; color: #fc95c4; margin-bottom: 10px; }
        .profile-name { font-size: 20px; font-weight: bold; }
        .profile-menu { list-style: none; padding: 0; margin-top: 20px; }
        .profile-menu .menu-item { padding: 10px; cursor: pointer; transition: 0.3s; }
        .profile-menu .menu-item.active, .profile-menu .menu-item:hover { background-color: #fc95c4; color: white; border-radius: 5px; }
        .profile-content { flex: 1; padding: 30px; }
        .content-section { display: none; }
        .content-section.active { display: block; }
        .logout-btn { color: red; text-decoration: underline; }
    </style>
</head>
<body>

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
   <script>
    const isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
</script>

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

            <!-- Form tìm kiếm -->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <!-- Icon User & Giỏ hàng -->
            <ul class="navbar-nav ml-3">
            <li class="nav-item d-flex align-items-center">
               
                        <a href="#" onclick="handleUserClick()">
                        <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                        </a>
                        <a href="#" onclick="handleCartClick()">
                            <i class="bi bi-bag-heart-fill custom-icon"  style="color:#fc95c4; font-size: 220%; padding-left:10px; padding-top:12px;"></i>
                        </a>

                        <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <span style="color: #fc95c4; font-weight: bold; padding-left: 10px;">
                                Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </span>
                            <a href="logout.php" class="btn btn-outline-danger ml-2">Đăng xuất</a>
                        </li>
                        
                        
                         <?php endif; ?>

  </li>
</ul>



        </div>
    </nav>
</div>

<div class="profile-container">
    <div class="profile-wrapper">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <i class="fa-solid fa-user-circle profile-icon"></i>
            <h2 class="profile-name"><?= htmlspecialchars($user['HoTen']) ?></h2>
            <ul class="profile-menu">
                <li class="menu-item active" data-target="info-section">Thông tin cá nhân</li>
                <li class="menu-item" data-target="order-history-section">Lịch sử đơn hàng</li>
                <li class="menu-item" data-target="logout-section">Đăng xuất</li>
            </ul>
        </div>

        <!-- Nội dung chính -->
        <div class="profile-content">
            <div id="info-section" class="content-section active">
            <div id="info-section" class="content-section active">
    <!-- Phần hiển thị thông tin -->
    <div id="view-info">
        <h3>Thông Tin Cá Nhân</h3>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?></p>
        <p><strong>SĐT:</strong> <?= htmlspecialchars($user['SoDienThoai']) ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['DiaChiCuThe']) ?>,
            <?= htmlspecialchars($user['PhuongXa']) ?>,
            <?= htmlspecialchars($user['QuanHuyen']) ?>,
            <?= htmlspecialchars($user['TPTinh']) ?></p>
        <p><strong>Vai trò:</strong> <?= htmlspecialchars($user['VaiTro']) ?></p>
        <button class="edit-btn btn btn-outline-primary mt-3" onclick="toggleEdit()" style="color:#fff">Chỉnh sửa thông tin</button>
    </div>

    <!-- Phần form cập nhật -->
    <div id="edit-info" style="display: none;">
        <h3>Chỉnh Sửa Thông Tin</h3>
        <form method="post" action="">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['Email']) ?>" required>
            </div>
            <div class="form-group">
                <label>SĐT:</label>
                <input type="text" name="sdt" class="form-control" value="<?= htmlspecialchars($user['SoDienThoai']) ?>" required>
            </div>
            <div class="form-group">
                <label>Địa chỉ:</label>
                <input type="text" name="diachi" class="form-control" value="<?= htmlspecialchars($user['DiaChiCuThe']) ?>" required>
            </div>
            <div class="form-group">
                <label>Phường/Xã:</label>
                <input type="text" name="phuongxa" class="form-control" value="<?= htmlspecialchars($user['PhuongXa']) ?>" required>
            </div>
            <div class="form-group">
                <label>Quận/Huyện:</label>
                <input type="text" name="quanhuyen" class="form-control" value="<?= htmlspecialchars($user['QuanHuyen']) ?>" required>
            </div>
            <div class="form-group">
                <label>Tỉnh/TP:</label>
                <input type="text" name="tptinh" class="form-control" value="<?= htmlspecialchars($user['TPTinh']) ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary mt-3">Cập nhật</button>
           <div class="text-center mt-2">
    <a href="#" class="text-decoration-underline text-secondary" onclick="toggleEdit()">Hủy</a>
</div>
        </form>
    </div>
</div>

            <div id="order-history-section" class="content-section">
                <h3>Lịch sử đơn hàng</h3>
                <ul>
                    <li>Đơn hàng #001 - Đã giao</li>
                    <li>Đơn hàng #002 - Đang xử lý</li>
                    <li>Đơn hàng #003 - Đã hủy</li>
                </ul>
            </div>
            <div id="logout-section" class="content-section">
                <h3>Đăng xuất</h3>
                <a href="includes/logout.php" class="logout-btn" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?');">Xác nhận đăng xuất</a>
            </div>
        </div>
    </div>  
</div>
</div>

<script>
    const menuItems = document.querySelectorAll(".menu-item");
    const sections = document.querySelectorAll(".content-section");

    menuItems.forEach(item => {
        item.addEventListener("click", () => {
            // Xóa class active khỏi tất cả menu
            menuItems.forEach(i => i.classList.remove("active"));
            item.classList.add("active");

            // Ẩn tất cả các section
            sections.forEach(s => s.classList.remove("active"));

            // Hiển thị section được chọn
            const target = item.getAttribute("data-target");
            document.getElementById(target).classList.add("active");
        });
    });

    function toggleEdit() {
        const viewInfo = document.getElementById("view-info");
        const editInfo = document.getElementById("edit-info");

        viewInfo.style.display = (viewInfo.style.display === "none") ? "block" : "none";
        editInfo.style.display = (editInfo.style.display === "none") ? "block" : "none";
    }

    function handleUserClick() {
        window.location.href = "user.php"; // Điều hướng đến trang hồ sơ cá nhân
    }

    function handleCartClick() {
        window.location.href = "trangGioHang.php"; // Điều hướng đến trang giỏ hàng
    }
</script>

</body>
</html>  