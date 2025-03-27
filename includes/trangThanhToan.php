

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh toán</title>
    
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Style chung -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    
    <style>
        .checkout-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1000px;
            margin: auto;
            gap: 20px;
        }
        .checkout-container, .order-summary {
            flex: 1;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-group label {
            font-weight: bold;
            display: block;
        }
        .form-group input {
            width: calc(100% - 16px);
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: inline-block;
        }
        .form-group {
            display: flex;
            flex-direction: column;
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
        }
        .order-summary h3 {
            text-align: center;
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
            margin-top: 15px;
        }
        .payment-method p {
            margin: 0;
        }
    </style>
</head>
<body>

<header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.html"><img src="images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="#navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a class="nav-link" href="index.html">Trang chủ</a></li>
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
                    <div class="login_bt">
                        <a href="#"><i class="fa-solid fa-user-large" style="color:#fc95c4; font-size: 150%;"></i></a>
                        <a href="includes/trangGioHang.php">
                            <i class="bi bi-bag-heart-fill custom-icon"></i>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
<div class="container my-5 checkout-wrapper">
    <div class="checkout-container">
        <h2 class="text-center">Thông tin thanh toán</h2>
        <form id="checkout-form">
            <div class="form-group">
                <label for="name">Họ và tên <span class="required">*</span></label>
                <input type="text" id="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại <span class="required">*</span></label>
                <input type="text" id="phone" required>
            </div>
            <div class="form-group">
                <label for="city">Tỉnh/Thành phố <span class="required">*</span></label>
                <input type="text" id="city" disabled>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ <span class="required">*</span></label>
                <input type="text" id="address" required>
            </div>
        </form>
    </div>
    
    <div class="order-summary">
        <h3>Đơn hàng của bạn</h3>
        <p><strong>Sản phẩm:</strong> Tropical Vibes Mousse – Mousse Ổi hồng & Chanh dây - 16cm</p>
        <p><strong>Tạm tính:</strong> 485.000 ₫</p>
        <p><strong>Giao hàng:</strong> 30.000 ₫</p>
        <p><strong>Tổng:</strong> <span style="color:red; font-weight: bold;">515.000 ₫</span></p>
        <div class="payment-method">
            <p><strong>Thanh toán tiền mặt khi nhận hàng</strong></p>
        </div>
        <button type="submit" class="btn-submit">Xác nhận thanh toán</button>
        <a href="trangGioHang.php" class="btn-back-cart">Quay lại giỏ hàng</a>
    </div>
</div>

<script>
    // Giả lập dữ liệu tài khoản đã đăng ký
    let userInfo = {
        name: "Nguyễn Văn A",
        phone: "0909123456",
        city: "Tp. Hồ Chí Minh",
        address: "123 Đường ABC, Quận 1"
    };

    // Tự động điền dữ liệu vào form
    document.getElementById("name").value = userInfo.name;
    document.getElementById("phone").value = userInfo.phone;
    document.getElementById("city").value = userInfo.city;
    document.getElementById("address").value = userInfo.address;

    document.getElementById("checkout-form").addEventListener("submit", function(event) {
        event.preventDefault(); // Ngăn chặn gửi form mặc định
        window.location.href = "hoanTatDonHang.php";
    });
</script>

</body>
</html>
