<?php require('includes/header.php');
  ?>
<div>
  <h3>
    Trang danh sách người dùng
  </h3>
 

  <?php
  require("./db/connect.php");

 $sql = "SELECT ND.id, ND.hoTen, ND.email, ND.soDienThoai,ND.gioiTinh,ND.ngaySinh, ND.matKhau, ND.VaiTro, 
                 ND.diaChiMacDinh, ND.ngayTao
          FROM NguoiDung AS ND
          JOIN KhachHang AS KH ON KH.nguoiDung = ND.id";
$result = mysqli_query($conn,$sql);

  ?>

    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Người Dùng</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã người dùng</th>
                                            <th>Họ tên</th>
                                            <th>Ngày sinh </th>
                                            <th>Giới tính</th>
                                            <th>Địa Chỉ</th>
                                            <th>Số điện thoại</th>
                                            <th>Mật khẩu</th>
                                            <th>Email</th>
                                            <th>Vai trò</th>
                                            <th>Ngày tạo</th>
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
                                            <th>Vai trò</th>
                                            <th>Ngày tạo</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if($result && mysqli_num_rows($result) > 0){
                                            while ($row = mysqli_fetch_assoc($result)){
                                                echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['hoTen']}</td>
                                                <td>{$row['ngaySinh']}</td>
                                                <td>{$row['gioiTinh']}</td>
                                                <td>{$row['diaChiMacDinh']}</td>                                                
                                                <td>{$row['soDienThoai']}</td>
                                                <td>{$row['matKhau']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['VaiTro']}</td>
                                                <td>{$row['ngayTao']}</td>
<td>
                                        <a href='edit_product.php?id={$row['id']}' class='btn btn-warning btn-sm'>Sửa</a>
                                        <a href='delete_product.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                                    </td>
                                                </tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>

          
    </tbody>
                                </table>
</div>
                        </div>
                    </div>
                </div>
    
         
   <?php require('includes/footer.php'); ?>

