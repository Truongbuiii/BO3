    <?php
    require('./db/connect.php');

    // Hàm để kiểm tra và ẩn sản phẩm có TinhTrang = 0 (khóa)
    function anSanPham($sanPhamId) {
        global $conn;

        // Truy vấn sản phẩm theo ID
        $query = "SELECT TinhTrang FROM SanPham WHERE MaSanPham = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $sanPhamId);
        $stmt->execute();
        $stmt->store_result();
        
        // Nếu có kết quả và TinhTrang = 0 (khóa), không hiển thị sản phẩm
        if ($stmt->num_rows > 0) {
            // Khai báo biến để nhận kết quả
            $stmt->bind_result($tinhTrang);
            $stmt->fetch();

            // Kiểm tra trạng thái sản phẩm
            if ($tinhTrang == 0) { // 0 là trạng thái "khóa"
                return false; // Trả về false để ẩn sản phẩm
            }
        }
        
        return true; // Nếu không phải "khóa", sản phẩm sẽ được hiển thị
    }
    ?>
