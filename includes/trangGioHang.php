<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng</title>
    
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Style chung -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    
    <style>
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        .cart-table th {
            background-color: blue;
            color: white;
            padding: 10px;
        }
        .cart-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .cart-summary {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
        .total-price {
            color: red;
            font-size: 20px;
            font-weight: bold;
        }
        .btn-checkout, .btn-continue, .btn-history {
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-checkout { background-color: orange; }
        .btn-continue { background-color: green; }
        .btn-history { background-color: teal; }
        .item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
            text-align: left;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.html"><img src="images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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

    <div class="container my-5 text-center" id="cart-list">
        <h2>Giỏ hàng</h2>
        <table class="text-center table table-bordered" style="vertical-align: middle;">
            <thead style="font-size: 20px; vertical-align: middle">
                <tr class="table-danger">
                    <th width="3%"><input type="checkbox" id="check-all" class="check" onclick="checkAllChanged()"></th>
                    <th width="20%">Hình ảnh</th>
                    <th width="45%">Tên sản phẩm</th>
                    <th width="10%">Số lượng</th>
                    <th width="15%">Giá</th>
                    <th width="7%"></th>
                </tr>
            </thead>
            <tbody id="cart-body">
                <tr>
                    <td><input type="checkbox" class="check"></td>
                    <td><img src="images/kemLyDau.jpg" class="item-img"></td>
                    <td>Kem dâu tươi</td>
                    <td class="item-quantity">2</td>
                    <td class="item-price">50000đ</td>
                    <td><button class="btn btn-danger">Xóa</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="check"></td>
                    <td><img src="images/kemQueSocola.jpg" class="item-img"></td>
                    <td>Kem socola</td>
                    <td class="item-quantity">1</td>
                    <td class="item-price">30000đ</td>
                    <td><button class="btn btn-danger">Xóa</button></td>
                </tr>
            </tbody>
        </table>

        <div id="cart-action">            
           
            <a href="./order.html" role="button" class="btn btn-warning">Xem lịch sử đặt hàng</a>
            <button class="btn btn-primary" onclick="continueShopping()">Tiếp tục xem sản phẩm</button>
            <button class="btn btn-danger" onclick="deleteAllCart()">Xóa giỏ hàng</button>
        </div>

        <div class="summary-box">
            <h4>Tóm tắt đơn hàng</h4>
            <p><strong>Tổng số sản phẩm:</strong> <span id="total-items">3</span></p>
            <p><strong>Tổng tiền:</strong> <span class="total-price" id="total-price">130000đ</span></p>
          
            <button class="btn-checkout" onclick="window.location.href='trangThanhToan.php'">Thanh toán</button>

        </div>
    </div>
</body>
</html>
