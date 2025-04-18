<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoàn tất đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffe6ec, #e3f6f5);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .thankyou-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .thankyou-container i {
            font-size: 60px;
            color: #90e0ef;
            margin-bottom: 20px;
        }

        .thankyou-container h2 {
            color: #0081a7;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .thankyou-container p {
            color: #555;
            font-size: 16px;
        }

        .btn-back-home {
            margin-top: 25px;
            padding: 10px 25px;
            background-color: #00b4d8;
            color: #fff;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-back-home:hover {
            background-color: #0077b6;
        }
    </style>
</head>
<body>
    <div class="thankyou-container">
        <i class="fa-solid fa-ice-cream"></i>
        <h2>Đơn hàng đã được đặt thành công!</h2>
        <p>Cảm ơn bạn đã lựa chọn cửa hàng kem của chúng tôi. Chúng tôi sẽ xác nhận đơn và giao hàng sớm nhất có thể.</p>
        <a href="../index.php" class="btn-back-home">Quay lại trang chủ</a>
    </div>
</body>
</html>
