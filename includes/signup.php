<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $tinh = $_POST['tinh'];
    $huyen = $_POST['huyen'];
    $xa = $_POST['xa'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $role = 'Customer';

    // Cấu hình kết nối
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "b03db";

    $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Kiểm tra mật khẩu xác nhận
    if ($password !== $confirmPassword) {
        echo "<script>alert('Mật khẩu xác nhận không khớp!'); window.history.back();</script>";
        exit();
    }

    // Kiểm tra trùng lặp
    $check = $conn->prepare("SELECT * FROM NguoiDung WHERE TenNguoiDung = ? OR Email = ? OR SoDienThoai = ?");
    $check->bind_param("sss", $username, $email, $phone);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập, Email hoặc Số điện thoại đã tồn tại!'); window.history.back();</script>";
        exit();
    }

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Thêm người dùng mới
    $sql = $conn->prepare("INSERT INTO NguoiDung (TenNguoiDung, MatKhau, HoTen, Email, SoDienThoai, VaiTro, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssssssss", $username, $hashedPassword, $fullname, $email, $phone, $role, $tinh, $huyen, $xa, $address);

    if ($sql->execute()) {
        echo "<script>alert('Đăng ký thành công!'); window.location.href = 'login.php';</script>";
    } else {
        echo "Lỗi: " . $sql->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="vi">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Đăng Ký</title>
      <link rel="stylesheet" href="/css/bootstrap.min.css">
      <link rel="stylesheet" href="/css/style.css">
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
                     <li class="nav-item active"><a class="nav-link" href="/index.php">Trang chủ</a></li>
                     <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ly</a></li>
                     <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ốc quế</a></li>
                     <li class="nav-item"><a class="nav-link" href="icecream.html">Kem que</a></li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                     <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                     <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                     </button>
                  </form>
               </div>
            </nav>
         </div>
      </div>
      
      <div class="cream_section layout_padding">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-6">
                  <div class="login_box p-4">
                     <h1 class="cream_taital text-center">Đăng ký</h1>
                     <form action="" method="POST">
                        <div class="form-group">
                           <label for="username">Tên đăng nhập:</label>
                           <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập của bạn">
                        </div>
                        
                        <div class="form-group">
                           <label for="fullname">Họ tên:</label>
                           <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ tên của bạn">
                        </div>
                        
                        <div class="form-group">
                           <label for="email">Email:</label>
                           <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn">
                        </div>
                        
                        <div class="form-group">
                           <label for="phone">Số điện thoại:</label>
                           <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn">
                        </div>
                        
                        <div class="form-group">
                           <label for="address">Địa chỉ:</label>
                           <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ cụ thể">
                        </div>

                        <div class="form-group">
                           <label for="tinh">Thành phố:</label>
                           <select class="form-control" id="tinh" name="tinh" onchange="loadHuyen()">
                               <option value="">Chọn Thành phố</option>
                           </select>
                        </div>

                        <div class="form-group">
                           <label for="huyen">Quận:</label>
                           <select class="form-control" id="huyen" name="huyen" onchange="loadXa()" disabled>
                               <option value="">Chọn Quận/Huyện</option>
                           </select>
                        </div>

                        <div class="form-group">
                           <label for="xa">Phường:</label>
                           <select class="form-control" id="xa" name="xa" disabled>
                               <option value="">Chọn Phường/Xã</option>
                           </select>
                        </div>

                        <div class="form-group">
                           <label for="password">Mật khẩu:</label>
                           <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu của bạn">
                        </div>
                        
                        <div class="form-group">
                           <label for="confirm-password">Xác nhận mật khẩu:</label>
                           <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Nhập lại mật khẩu của bạn">
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Đăng ký</button>
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
      <script src="js/bootstrap.bundle.min.js"></script>

      <script>
         const addressData = {
            "TP Hồ Chí Minh": {
                    "Quận 1": ["Phường Cầu Kho","Phường Bến Nghé", "Phường Bến Thành", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Nguyễn Thái Bình"],
        "Quận 2":["Phường An Phú","Phường Tân Bình","Phường Tân Phú"],
        "Quận 3": ["Phường Võ Thị Sáu", "Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7","Phường 14"],
        "Quận 4":["Phường 10","Phường 11","Phường 12","Phường 13"],
        "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 8"],
        "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10"],
        "Quận 7": ["Phường Tân Thuận Tây","Phường Tân Phong", "Phường Tân Hưng", "Phường Bình Thuận", "Phường Phú Mỹ", "Phường Tân Kiểng", "Phường Tân Quy", "Phường Tân Phú"],
        "Quận 8":["Phường 11","Phường 15"],
        "Quận 9":["Phường Hiệp Phú","Phường Hiệp Bình Chánh","Phường Long Trường"],
        "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8","Phường 9"],
        "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 16", "Phường 7"],
        "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 25", "Phường 6", "Phường 7", "Phường 8"],
        "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
        "Thành phố Thủ Đức": ["Phường Bình Chiểu", "Phường Bình Thọ", "Phường Hiệp Bình Chánh", "Phường Hiệp Phú", "Phường Linh Trung", "Phường Linh Đông"],
        "Quận Bình Tân": ["Phường Bình Hưng Hòa", "Phường Bình Trị Đông", "Phường Tân Tạo", "Phường An Lạc", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B"],
        "Huyện Nhà Bè": ["Xã Phước Kiển", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức"],
        "Quận Phú Nhuận":["Phường 9"]

            }
        };

        window.onload = function () {
            const tinhSelect = document.getElementById("tinh");
            Object.keys(addressData).forEach(tinh => {
                let option = document.createElement("option");
                option.value = tinh;
                option.text = tinh;
                tinhSelect.appendChild(option);
            });
        };

        function loadHuyen() {
            const tinhSelect = document.getElementById("tinh");
            const huyenSelect = document.getElementById("huyen");
            const xaSelect = document.getElementById("xa");

            huyenSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            xaSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
            xaSelect.disabled = true;

            if (tinhSelect.value) {
                Object.keys(addressData[tinhSelect.value]).forEach(huyen => {
                    let option = document.createElement("option");
                    option.value = huyen;
                    option.text = huyen;
                    huyenSelect.appendChild(option);
                });
                huyenSelect.disabled = false;
            } else {
                huyenSelect.disabled = true;
            }
        }

        function loadXa() {
            const tinhSelect = document.getElementById("tinh");
            const huyenSelect = document.getElementById("huyen");
            const xaSelect = document.getElementById("xa");

            xaSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

            if (huyenSelect.value) {
                addressData[tinhSelect.value][huyenSelect.value].forEach(xa => {
                    let option = document.createElement("option");
                    option.value = xa;
                    option.text = xa;
                    xaSelect.appendChild(option);
                });
                xaSelect.disabled = false;
            } else {
                xaSelect.disabled = true;
            }
        }
      </script>
   </body>
</html>
