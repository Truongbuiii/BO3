<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoàn tất đơn hàng</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            text-align: center;
            padding: 50px;
            background-color: #f9f9f9;
        }
        .completion-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .completion-container h2 {
            color: #28a745;
        }
        .completion-container p {
            font-size: 18px;
            color: #555;
        }
        .btn-home {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                window.location.href = "index.html";
            }, 5000); // Chuyển về trang chủ sau 5 giây
        });
    </script>
</head>
<body>
    <div class="completion-container">
        <i class="fa-solid fa-check-circle" style="font-size: 50px; color: #28a745;"></i>
        <h2>Đơn hàng của bạn đã được đặt thành công!</h2>
        <p>Cảm ơn bạn đã mua hàng tại cửa hàng kem của chúng tôi. Chúng tôi sẽ sớm xác nhận và giao hàng đến bạn.</p>
        <a href="index.html" class="btn-home">Quay lại trang chủ</a>
    </div>
</body>
</html>
