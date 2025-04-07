<?php require('includes/header.php'); ?>
<div>
  <h3>Trang danh sách sản phẩm</h3>

        <?php
        require("./db/connect.php");

        $sql = "SELECT HD.MaHoaDon ,HD.TenNguoiDung,HD.NguoiNhanHang,HD.TPTinh, HD.QuanHuyen, HD.PhuongXa, HD.DiaChiCuThe, HD.NgayGio, HD.Email, HD.TongTien, HD.TrangThai, HD.HinhThucThanhToan
        FROM HoaDon AS HD
";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn)); // Kiểm tra lỗi truy vấn
}
        ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <div class="order-list">
                    <div class="filter-container">
                        <div class="filter">
                            <label for="start-date">Từ ngày:</label>
                            <input type="date" id="start-date">
                            <label for="end-date">Đến ngày:</label>
                            <input type="date" id="end-date">
                        </div>
                        <div class="loctinhtrang">
                            <label for="tinhtrang">Lọc theo tình trạng:</label>
                            <select id="tinhtrang" name="tinhtrang">
                                <option value="" disabled selected>-- Chọn tình trạng --</option>
                                <option value="dangxuly">Chưa xử lý</option>
                                <option value="daxacnhan">Đã xác nhận</option>
                                <option value="dagiaothanhcong">Đã giao thành công</option>
                                <option value="dahuy">Đã huỷ</option>
                            </select>
                        </div>
                        <div class="nut">
                            <button class="loc" id="loc">Lọc</button>
                        </div>
                    </div>
                     </div>
                     
                      <tr>
                          <th>Mã đơn hàng</th>
                          <th>Tên Người nhận</th>
                          <th>Email</th>
                          <th>Thành phố/ Tỉnh</th>
                          <th>Quận / Huyện</th>
                          <th>Phường / Xã</th>
                          <th>Địa chỉ cụ thể</th>
                          <th>Ngày giờ</th>
                          <th>Tổng tiền</th>
                          <th>Trạng thái</th>
                          <th>Hình thức thanh toán</th>
                          <th>Chức năng</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                           <th>Mã đơn hàng</th>
                          <th>Tên Người nhận</th>
                          <th>Email</th>
                          <th>Thành phố/ Tỉnh</th>
                          <th>Quận / Huyện</th>
                          <th>Phường / Xã</th>
                          <th>Địa chỉ cụ thể</th>
                          <th>Ngày giờ</th>
                          <th>Tổng tiền</th>
                          <th>Trạng thái</th>
                          <th>Hình thức thanh toán</th>
                          <th>Chức năng</th>
                      </tr>
                  </tfoot>
                  <tbody>

                  <?php
                  if($result && mysqli_num_rows($result) > 0 ){
                        while ($row = mysqli_fetch_assoc($result)){
                            echo "<tr>
                            <td>{$row['MaHoaDon']}</td>
                            <td>{$row['NguoiNhanHang']}</td>
                            <td>{$row['Email']}</td>
                            <td>{$row['TPTinh']}</td>
                            <td>{$row['QuanHuyen']}</td>
                            <td>{$row['PhuongXa']}</td>
                            <td>{$row['DiaChiCuThe']}</td>
                            <td>{$row['NgayGio']}</td>
                            <td>{$row['TongTien']}</td>
                            <td>{$row['TrangThai']}</td>
                            <td>{$row['HinhThucThanhToan']}</td>
<td>
                 <button class='btn btn-warning btn-sm'>Sửa</button>
                                      </td>
                            
                            
                            </tr>";
                        }

                  }
                  ?>


                 
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<?php require('includes/footer.php'); ?>
