<?php require('includes/header.php');
  ?>
<div>
  <h3>
    Trang danh sách người dùng
  </h3>
 

    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Người Dùng</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã Khách Hàng</th>
                                            <th>Họ tên</th>
                                            <th>Ngày sinh </th>
                                            <th>Giới tính</th>
                                            <th>Địa Chỉ</th>
                                            <th>Số điện thoại</th>
                                            <th>Mật khẩu</th>
                                            <th>Email</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Mã Khách Hàng</th>
                                            <th>Họ tên</th>
                                            <th>Ngày sinh </th>
                                            <th>Giới tính</th>
                                            <th>Địa Chỉ</th>
                                            <th>Số điện thoại</th>
                                            <th>Mật khẩu</th>
                                            <th>Email</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

            <?php
require('../db/conn.php'); // Gọi file kết nối CSDL

$sql_str = "SELECT * FROM KhachHang ORDER BY MaKhachHang";
$result = mysqli_query($conn, $sql_str);

while ($row = mysqli_fetch_assoc($result)) { 
?>
    <tr>
        <td><?php echo $row['MaKhachHang']; ?></td>
        <td><?php echo $row['HoTen']; ?></td>
        <td><?php echo $row['NgaySinh']; ?></td>
        <td><?php echo $row['GioiTinh']; ?></td>
        <td><?php echo $row['DiaChi']; ?></td>
        <td><?php echo $row['SDT']; ?></td>
        <td><?php echo $row['MatKhau']; ?></td>
       <td><?php echo $row['Email']; ?></td>
       <td>Sửa  ||  Khóa</td>
    </tr>
<?php 
}
?>
    </tbody>
                                </table>
</div>
                        </div>
                    </div>
                </div>
    
         
   <?php require('includes/footer.php'); ?>

