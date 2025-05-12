
<?php
session_start(); // Khởi tạo session

require(__DIR__ . "/../db/connect.php");


// Kiểm tra nếu giỏ hàng trống thì chuyển hướng về trang chủ
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Không có sản phẩm để thanh toán!'); window.location.href = '/index.php';</script>";
    exit();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập để tiếp tục thanh toán!'); window.location.href = '/login.php';</script>";
    exit();
}

// Lấy thông tin người dùng từ database
$username = $_SESSION['username'];
$sql = "SELECT HoTen, Email, SoDienThoai, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe FROM NguoiDung WHERE TenNguoiDung = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "<script>alert('Không tìm thấy thông tin người dùng!'); window.location.href = '/index.php';</script>";
    exit();
}
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
      .checkout-wrapper {
         display: flex;
         justify-content: space-between;
         align-items: flex-start;
         max-width: 1300px;
         margin: auto;
         gap: 40px;
      }

      .checkout-container, .order-summary {
         flex: 0.5;
         padding: 30px;
         border: 1px solid #ddd;
         border-radius: 10px;
         background-color: #f9f9f9;
         font-size: 14px;
      }

      .order-summary h2, .checkout-container h2 {
         text-align: center;
         font-size: 24px;
         margin-bottom: 20px;
      }

      .form-group {
         margin-bottom: 15px;
      }

      .form-group label {
         font-weight: bold;
         display: block;
      }

      .form-group input {
         width: 100%;
         padding: 8px;
         margin-top: 5px;
         border: 1px solid #ccc;
         border-radius: 5px;
      }

      .required {
         color: red;
      }

      .btn-submit {
         background-color: orange;
         color: white;
         padding: 10px;
         border: none;
         width: 100%;
         border-radius: 5px;
         cursor: pointer;
         font-size: 14px;
         margin-top: 20px;
      }

      .btn-back-cart {
         display: block;
         text-align: center;
         margin-top: 15px;
         padding: 10px;
         background-color: #f44336;
         color: white;
         text-decoration: none;
         border-radius: 5px;
      }

      .payment-method {
         padding: 15px;
         border: 1px solid #ddd;
         border-radius: 5px;
         background-color: #fff3cd;
         margin-top: 20px;
      }

      .hidden {
         display: none;
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
                  <ul class="navbar-nav ml-3">
                    <li class="nav-item d-flex align-items-center">
                        <a href="user.php" onclick="handleUserClick()">
                            <i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 220%; padding-left:10px;"></i>
                        </a>
                        <a href="trangGioHang.php" onclick="handleCartClick()">
                            <i class="bi bi-bag-heart-fill" style="color:#fc95c4; font-size: 220%; padding-left:10px;"></i>
                        </a>
                        <?php if (isset($_SESSION['username'])): ?>
                            <span style="color: #fc95c4; font-weight: bold; padding-left: 10px;">
                                Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </span>
                            <a href="logout.php" class="btn btn-outline-danger ml-2">Đăng xuất</a>
                        <?php endif; ?>
                    </li>
                </ul>
               </div>
            </nav>
         </div>



 <!-- Checkout Form Section -->
<div class="container my-5 checkout-wrapper">
    <div class="checkout-container">
        <h2>Thông tin thanh toán</h2>
      <form id="checkout-form" method="POST" action="xuLyHoanTatDonHang.php">
            <div class="form-group">
                <label for="name">Họ và tên <span class="required">*</span></label>
                <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($userData['HoTen']); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($userData['Email']); ?>">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại <span class="required">*</span></label>
                <input type="text" id="phone" name="phone" required value="<?php echo htmlspecialchars($userData['SoDienThoai']); ?>">
            </div>
            <div class="form-group">
                <label>Chọn địa chỉ giao hàng <span class="required">*</span></label>
                <input type="radio" name="address-option" id="use-account" checked> Dùng địa chỉ tài khoản
                <input type="radio" name="address-option" id="enter-new" style="margin-left:20px;"> Nhập địa chỉ mới
            </div>
                

                <!-- Account Address -->
            <div id="account-address">
                <div class="form-group">
                    <label for="city">Tỉnh/Thành phố</label>
                    <input type="text" id="city" name="city" readonly value="<?php echo htmlspecialchars($userData['TPTinh']); ?>">
                </div>
                <div class="form-group">
                    <label for="district">Quận/Huyện</label>
                    <input type="text" id="district" name="district" readonly value="<?php echo htmlspecialchars($userData['QuanHuyen']); ?>">
                </div>
                <div class="form-group">
                    <label for="ward">Phường/Xã</label>
                    <input type="text" id="ward" name="ward" readonly value="<?php echo htmlspecialchars($userData['PhuongXa']); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                    <input type="text" id="address" name="address" readonly value="<?php echo htmlspecialchars($userData['DiaChiCuThe']); ?>">
                </div>

            </div>

                <!-- New Address -->
<div id="new-address" class="hidden">
    <div class="form-group">
        <label for="new-city">Tỉnh/Thành phố <span class="required">*</span></label>
        <select id="new-city" name="new-city" required>
            <option value="">-- Chọn Tỉnh/Thành phố --</option>
            <option value="HCM">TP. Hồ Chí Minh</option>
        </select>
    </div>
    <div class="form-group">
        <label for="new-district">Quận/Huyện <span class="required">*</span></label>
        <select id="new-district" name="new-district" required>
            <option value="">-- Chọn Quận/Huyện --</option>
        </select>
    </div>
    <div class="form-group">
        <label for="new-ward">Phường/Xã <span class="required">*</span></label>
        <select id="new-ward" name="new-ward" required>
            <option value="">-- Chọn Phường/Xã --</option>
        </select>
    </div>
    <div class="form-group">
        <label for="new-address-detail">Địa chỉ cụ thể <span class="required">*</span></label>
        <input type="text" id="new-address-detail" name="new-address-detail" required>
    </div>
</div>


                <!-- Payment Method Section -->
                <div class="form-group">
                    <label for="payment-method">Chọn phương thức thanh toán <span class="required">*</span></label>
                    <select id="payment-method" required>
                        <option value="online">Thanh toán trực tuyến</option>
                        <option value="cod">Tiền mặt khi nhận hàng</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="order-summary">
            <h2>Đơn hàng của bạn</h2>
            <?php
            // Check if cart is not empty
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $tongTien = 0;
                echo "<ul>";
                foreach ($_SESSION['cart'] as $item) {
                    $thanhTien = $item['DonGia'] * $item['quantity'];
                    $tongTien += $thanhTien;
                    echo "<li><strong>{$item['TenSanPham']}</strong> - " . number_format($item['DonGia'], 0, ',', '.') . " VND x {$item['quantity']} = " . number_format($thanhTien, 0, ',', '.') . " VND</li>";
                }
                echo "</ul>";
                $shippingFee = 30000; // example shipping fee
                $totalAmount = $tongTien + $shippingFee;
                echo "<p><strong>Tạm tính:</strong> " . number_format($tongTien, 0, ',', '.') . " VND</p>";
                echo "<p><strong>Giao hàng:</strong> " . number_format($shippingFee, 0, ',', '.') . " VND</p>";
                echo "<p><strong>Tổng:</strong> <span style='color:red; font-weight: bold;'>" . number_format($totalAmount, 0, ',', '.') . " VND</span></p>";
            } else {
                echo "<p>Không có sản phẩm trong giỏ hàng.</p>";
            }
            ?>

            <button type="button" class="btn-submit" onclick="confirmPayment()">Xác nhận thanh toán</button>

            <a href="trangGioHang.php" class="btn-back-cart">Quay lại giỏ hàng</a>
        </div>
    </div>

  
    </script><script>
const addressData = {
    "TP. Hồ Chí Minh": {
       "Quận 1": ["Phường Tân Định", "Phường Đa Kao", "Phường Bến Nghé", "Phường Bến Thành", "Phường Nguyễn Thái Bình", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Nguyễn Cư Trinh", "Phường Phạm Ngũ Lão", "Phường Cầu Kho"],
    "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường Võ Thị Sáu"],
    "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 6", "Phường 8", "Phường 9", "Phường 10", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 18"],
    "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
    "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
    "Quận 7": ["Phường Tân Thuận Đông", "Phường Tân Thuận Tây", "Phường Tân Kiểng", "Phường Tân Hưng", "Phường Tân Phong", "Phường Tân Phú", "Phường Phú Mỹ", "Phường Phú Thuận", "Phường Bình Thuận", "Phường Tân Quy"],
    "Quận 8": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
    "Quận 10": ["Phường 1", "Phường 2", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
    "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
    "Quận 12": ["Phường An Phú Đông", "Phường Đông Hưng Thuận", "Phường Hiệp Thành", "Phường Tân Chánh Hiệp", "Phường Tân Hưng Thuận", "Phường Tân Thới Hiệp", "Phường Tân Thới Nhất", "Phường Thạnh Lộc", "Phường Thạnh Xuân", "Phường Thới An", "Phường Trung Mỹ Tây"],
    "Quận Bình Tân": ["Phường An Lạc", "Phường An Lạc A", "Phường Bình Hưng Hòa", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B", "Phường Bình Trị Đông", "Phường Bình Trị Đông A", "Phường Bình Trị Đông B", "Phường Tân Tạo", "Phường Tân Tạo A"],
    "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"],
    "Quận Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 17"],
    "Quận Phú Nhuận": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 13", "Phường 15", "Phường 17"],
    "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
    "Quận Tân Phú": ["Phường Hiệp Tân", "Phường Hòa Thạnh", "Phường Phú Thạnh", "Phường Phú Thọ Hòa", "Phường Phú Trung", "Phường Sơn Kỳ", "Phường Tân Quý", "Phường Tân Sơn Nhì", "Phường Tân Thành", "Phường Tây Thạnh"],
    "Thành phố Thủ Đức": ["Phường Hiệp Bình Chánh", "Phường Hiệp Bình Phước", "Phường Linh Chiểu", "Phường Linh Đông", "Phường Linh Tây", "Phường Linh Trung", "Phường Linh Xuân", "Phường Bình Chiểu", "Phường Bình Thọ", "Phường Tam Bình", "Phường Tam Phú", "Phường Trường Thọ", "Phường Bình An", "Phường Bình Trưng Đông", "Phường Bình Trưng Tây", "Phường Cát Lái", "Phường Thảo Điền", "Phường An Khánh", "Phường An Phú", "Phường Phước Long A", "Phường Phước Long B", "Phường Tăng Nhơn Phú A", "Phường Tăng Nhơn Phú B", "Phường Phước Bình", "Phường Tân Phú", "Phường Trường Thạnh", "Phường Long Thạnh Mỹ", "Phường Long Phước", "Phường Long Trường", "Phường Phú Hữu", "Phường Thạnh Mỹ Lợi", "Phường Thủ Thiêm"],
    "Huyện Nhà Bè": ["Xã Phước Kiển", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức"],
    "Quận Phú Nhuận": ["Phường 9"]
    }
};

const citySelect = document.getElementById('new-city');
const districtSelect = document.getElementById('new-district');
const wardSelect = document.getElementById('new-ward');

// Khi chọn tỉnh/thành
citySelect.addEventListener('change', function () {
    const selectedCity = citySelect.options[citySelect.selectedIndex].text;
    districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
    if (addressData[selectedCity]) {
        for (const district in addressData[selectedCity]) {
            const option = document.createElement('option');
            option.value = district;
            option.text = district;
            districtSelect.appendChild(option);
        }
    }
});

// Khi chọn quận/huyện
districtSelect.addEventListener('change', function () {
    const selectedCity = citySelect.options[citySelect.selectedIndex].text;
    const selectedDistrict = this.value;
    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
    if (addressData[selectedCity] && addressData[selectedCity][selectedDistrict]) {
        addressData[selectedCity][selectedDistrict].forEach(ward => {
            const option = document.createElement('option');
            option.value = ward;
            option.text = ward;
            wardSelect.appendChild(option);
        });
    }
});

// Ẩn/hiện địa chỉ theo lựa chọn
const useAccountRadio = document.getElementById('use-account');
const enterNewRadio = document.getElementById('enter-new');
const accountAddress = document.getElementById('account-address');
const newAddress = document.getElementById('new-address');

useAccountRadio.addEventListener('change', () => {
    if (useAccountRadio.checked) {
        accountAddress.classList.remove('hidden');
        newAddress.classList.add('hidden');
    }
});
enterNewRadio.addEventListener('change', () => {
    if (enterNewRadio.checked) {
        accountAddress.classList.add('hidden');
        newAddress.classList.remove('hidden');
    }
});

// Xác nhận thanh toán
function confirmPayment() {
    const method = document.getElementById('payment-method').value;
    const isUsingNew = enterNewRadio.checked;

    if (isUsingNew) {
        if (!citySelect.value || !districtSelect.value || !wardSelect.value || !document.getElementById('new-address-detail').value) {
            alert("Vui lòng nhập đầy đủ địa chỉ mới!");
            return;
        }
    }

    alert("Đặt hàng thành công với phương thức: " + (method === 'cod' ? "Tiền mặt khi nhận hàng" : "Thanh toán trực tuyến"));
    // Có thể thực hiện gọi API POST để lưu vào DB ở đây.
    // Chuyển hướng đến trang "Hoàn tất đơn hàng"
    window.location.href = "/includes/hoanTatDonHang.php";

}
</script>

</body>
</html>