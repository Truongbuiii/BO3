<?php
session_start(); // Đảm bảo session được khởi tạo ở đầu file PHP

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$dbusername = "root"; // Thay đổi theo thông tin của bạn
$dbpassword = ""; // Thay đổi theo thông tin của bạn
$dbname = "tiemkem"; // Tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['email']; // Lấy tên đăng nhập
    $pass = $_POST['password']; // Lấy mật khẩu

    // Truy vấn để lấy thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM NguoiDung WHERE TenNguoiDung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user); // Gán tham số
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Dữ liệu người dùng đã được tìm thấy
        $row = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu (nếu mật khẩu được mã hóa)
        if (password_verify($pass, $row['MatKhau'])) {
            // Mật khẩu đúng, đăng nhập thành công
            $_SESSION['username'] = $row['TenNguoiDung'];
            $_SESSION['role'] = $row['VaiTro']; // Nếu cần kiểm tra vai trò

            // Chuyển hướng về trang chủ với tên người dùng
            header("Location: /index.php");
exit();

            exit();
        } else {
            // Mật khẩu sai
            echo "<script>alert('Sai mật khẩu!'); window.location.href = 'login.php';</script>";
        }
    } else {
        // Người dùng không tồn tại
        echo "<script>alert('Tên đăng nhập không tồn tại!'); window.location.href = 'login.php';</script>";
    }
}

// Đóng kết nối
$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="icon" href="/images/fevicon.png" type="image/gif"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="header_section header_bg">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.html"><img src="/images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="index.html">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ly</a></li>
                        <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ốc quế</a></li>
                        <li class="nav-item"><a class="nav-link" href="icecream.html">Kem que</a></li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 mr-3">
    <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</form>

<?php if (isset($_SESSION['username'])): ?>
    <!-- Nếu đã đăng nhập -->
    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user"></i> <?= htmlspecialchars($_SESSION['username']) ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="profile.php">Hồ sơ cá nhân</a>
            <a class="dropdown-item" href="logout.php">Đăng xuất</a>
        </div>
    </div>
<?php else: ?>
    <!-- Nếu chưa đăng nhập -->
    <button class="btn btn-outline-primary" onclick="showUserPopup()">
        <i class="fa fa-user"></i>
    </button>
<?php endif; ?>

                  
                </div>
            </nav>
        </div>
    </div>
 
    <div class="cream_section1 layout_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login_box p-4">
                        <h1 class="cream_taital text-center">Đăng nhập</h1>
                        <form action="login.php" method="POST">
                            <div class="form-group">
                                <label for="email">Tên đăng nhập:</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Nhập tên đăng nhập của bạn" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                            <div class="text-center mt-3">
                                <a href="/index.php" class="text-decoration-none">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>

    <script>
    function showUserPopup() {
        if (document.getElementById("user-popup")) {
            document.getElementById("user-popup").style.display = "flex";
            return;
        }

        const popup = document.createElement("div");
        popup.id = "user-popup";
        popup.className = "popup";
        popup.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex; align-items: center; justify-content: center;
            z-index: 1000;
        `;

        const popupContent = document.createElement("div");
        popupContent.className = "popup-content";
        popupContent.style.cssText = `
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        `;

        popupContent.innerHTML = `
            <p style="margin-bottom: 20px;">Bạn muốn thực hiện gì?</p>
            <button style="margin: 8px;" onclick="window.location.href='includes/login.php'">Đăng nhập</button>
            <button style="margin: 8px;" onclick="window.location.href='includes/signup.php'">Đăng ký</button>
            <button style="margin: 8px;" onclick="document.getElementById('user-popup').remove()">Hủy</button>
        `;

        popup.appendChild(popupContent);
        document.body.appendChild(popup);
    }
</script>

</body>
</html>
