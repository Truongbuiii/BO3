

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
            max-width: 1300px;
            margin: auto;
            gap: 40px;
           

        }
        .checkout-container, .order-summary {
            flex: 2;
            padding: 40px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            font-size: 18px;
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
            font-size: 16px;
        }
        .order-summary h3 {
            text-align: center;
            font-size: 28px;
            
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
        .payment-method p {
            margin: 0;
        }
        
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .navbar-brand img {
            max-height: 80px;
        }

        .navbar-nav {
            display: flex;
            flex-grow: 1;
            justify-content: center;
            gap: 50px;
        }

        .navbar-nav .nav-item {
            list-style: none;
        }

        .navbar-nav .nav-link {
            font-size: 22px;
            text-decoration: none;
            color: #000;
            font-weight: 500;
        }

        .navbar-nav .nav-item:first-child .nav-link {
            color: #fc95c4;
            font-weight: bold;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .search-container input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .search-container button {
            background: none;
            border: 1px solid green;
            padding:  12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 25px;
            padding: 10px 15px;
        }

        .icons i {
            font-size: 35px;
            color: #fc95c4;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <a class="navbar-brand" href="index.php"><img src="/images/logo.png" alt="Logo"></a>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item active"><a class="nav-link" href="index.php">Trang chủ</a></li>
            <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ốc quế</a></li>
            <li class="nav-item"><a class="nav-link" href="icecream.html">Kem ly</a></li>
            <li class="nav-item"><a class="nav-link" href="icecream.html">Kem que</a></li>
        </ul>
    </nav>
    <div class="search-container">
        <input type="text" placeholder="Tìm kiếm...">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <div class="icons">
        <i class="fa-solid fa-user-large"></i>
       
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
    <label for="email">Email <span class="required">*</span></label>
    <input type="email" id="email">
</div>
            <div class="form-group">
                <label for="phone">Số điện thoại <span class="required">*</span></label>
                <input type="text" id="phone" required>
            </div>
            <div class="form-group">
                <label for="city">Tỉnh/Thành phố <span class="required"></span></label>
                <input type="text" id="city" disabled>
            </div>
            <div class="form-group">
    <label for="district">Quận/Huyện <span class="required">*</span></label>
    <input type="text" id="district" disabled>
</div>
<div class="form-group">
    <label for="ward">Phường/Xã <span class="required"></span>*</label>
    <input type="text" id="ward" disabled>
</div>
            <div class="form-group">
                <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
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
        <button id="btn-thanh-toan" class="btn-submit">Xác nhận thanh toán</button>


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

    document.getElementById("btn-thanh-toan").onclick = function() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let address = document.getElementById("address").value.trim();

    if (!name || !email || !phone || !address) {
        alert("Vui lòng điền đầy đủ thông tin trước khi thanh toán!");
        return;
    }

    // Nếu thông tin hợp lệ, chuyển hướng sang trang hoàn tất đơn hàng
    window.location.href = "hoanTatDonHang.php";
};

</script>

</body>
</html>
