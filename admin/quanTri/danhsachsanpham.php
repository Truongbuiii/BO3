<?php require('includes/header.php'); ?>
<div>
  <h3>Trang danh sách sản phẩm</h3>
<?php

require("../db/connect.php"); // Đảm bảo file kết nối đúng

$sql = "SELECT SanPham.id, SanPham.tenSanPham, LoaiKem.tenLoaiKem, SanPham.huongVi, 
               SanPham.tinhTrang, SanPham.gia, SanPham.hinhAnh, 
               SanPham.soLuongCon, SanPham.soLuongDaBan
        FROM SanPham
        JOIN LoaiKem ON SanPham.LoaiKem = LoaiKem.id"; 

$result = mysqli_query($conn, $sql);
?>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại kem</th>
                        <th>Vị kem</th>
                        <th>Tình trạng</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng hàng còn</th>
                        <th>Số lượng đã bán</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại kem</th>
                        <th>Vị kem</th>
                        <th>Tình trạng</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng hàng còn</th>
                        <th>Số lượng đã bán</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['tenSanPham']}</td>
                                    <td> {$row['tenLoaiKem']}</td>
                                    <td>{$row['huongVi']}</td>
                                    <td>{$row['tinhTrang']}</td>
                                    <td>" . number_format($row['gia'], 0, ',', '.') . " VND</td>
                                    <td><img src='images/{$row['hinhAnh']}' width='50'></td>
                                    <td>{$row['soLuongCon']}</td>
                                    <td>{$row['soLuongDaBan']}</td>
                                    <td>
                                        <a href='edit_product.php?id={$row['id']}' class='btn btn-warning btn-sm'>Sửa</a>
                                        <a href='delete_product.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>Không có sản phẩm nào</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require('includes/footer.php'); ?>
