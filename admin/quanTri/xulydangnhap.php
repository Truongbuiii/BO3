<?php
// Include file kết nối CSDL
                session_start();

require_once './db/connect.php';

// Lấy dữ liệu từ form
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Biến lưu thông báo để hiển thị trong popup
$message = "";
$success = false;

// Kiểm tra nếu có tên người dùng và mật khẩu
if (!empty($username) && !empty($password)) {
    // Chuẩn bị truy vấn để tránh SQL injection
    $stmt = $conn->prepare("SELECT TenNguoiDung, MatKhau, VaiTro FROM NguoiDung WHERE TenNguoiDung = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['MatKhau'];

        // Kiểm tra mật khẩu và vai trò
        if (password_verify($password, $hashedPassword)) {
            $role = trim($row['VaiTro']);  // Loại bỏ khoảng trắng trong vai trò

            // Kiểm tra vai trò Admin
            if ($role === 'Admin') {
                // Lưu thông tin vào session
                $_SESSION['adminid'] = $row['TenNguoiDung'];
                $_SESSION['admin_role'] = $role;
                $_SESSION['loggedin'] = true;

// Lưu thông tin vào cookie
setcookie("adminid", $row['TenNguoiDung'], time() + 3600, "/", "", isset($_SERVER['HTTPS']), true);

                $message = "✅ Đăng nhập thành công!";
                $success = true;
            } else {
                $message = "❌ Bạn không đủ thẩm quyền để truy cập!";
            }
        } else {
            $message = "❌ Sai mật khẩu!";
        }
    } else {
        $message = "❌ Tên người dùng không tồn tại!";
    }

    // Đóng kết nối
    $stmt->close();
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo đăng nhập</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f1f3f5;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.3s ease-out;
            max-width: 400px;
            width: 90%;
        }

        .popup i {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .popup.success i {
            color: #28a745;
        }

        .popup.error i {
            color: #dc3545;
        }

        .popup h2 {
            margin: 10px 0;
            font-size: 22px;
            font-weight: 600;
        }

        .popup p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #555;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }
    </style>
</head>
<body>
    <div class="popup <?php echo $success ? 'success' : 'error'; ?>">
        <i class="fa-<?php echo $success ? 'regular fa-circle-check' : 'solid fa-circle-xmark'; ?>"></i>
        <h2>
            <?php echo $success ? 'Đăng nhập thành công!' : 'Đăng nhập thất bại!'; ?>
        </h2>
        <p><?php echo $message; ?></p>
    </div>

    <script>
        setTimeout(() => {
            <?php if ($success): ?>
                window.location.href = "/admin/quantri/index.php"; // Đưa tới trang quản trị
            <?php else: ?>
                setTimeout(() => {
                    window.history.back(); // Quay lại trang đăng nhập sau khi thất bại
                }, 1200);
            <?php endif; ?>
        }, 1200);
    </script>
</body>
</html>
