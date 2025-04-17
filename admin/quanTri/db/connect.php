<?php
// Khai báo thông tin kết nối
if (!defined('DB_SERVER')) {
    define('DB_SERVER', 'localhost'); // hoặc 'lab2024.daihocsaigon.edu.vn' nếu dùng online
}

if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root'); // Nếu dùng local thì là root, nếu trên server thì là b03u
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', ''); // Nếu dùng local (XAMPP) thì rỗng, nếu trên server thì dùng mật khẩu
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'tiemkem'); // Tên database, ví dụ: 'tiemkem' hoặc 'b03db'
}

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error){
    die("Lỗi: không kết nối được database. " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

?>
