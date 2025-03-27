<?php require('includes/header.php'); ?>
<div>
  <h3>Trang danh sách sản phẩm</h3>

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
                          <th>Mã khách hàng</th>
                          <th>Tên khách hàng</th>
                          <th>Đơn hàng</th>
                          <th>Ngày</th>
                          <th>Giờ</th>
                          <th>Tổng tiền</th>
                          <th>Địa chỉ</th>
                          <th>Chức năng</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                           <th>Mã đơn hàng</th>
                          <th>Mã khách hàng</th>
                          <th>Tên khách hàng</th>
                          <th>Đơn hàng</th>
                          <th>Ngày</th>
                          <th>Giờ</th>
                          <th>Tổng tiền</th>
                          <th>Địa chỉ</th>
                          <th>Chức năng</th>
                      </tr>
                  </tfoot>
                  <tbody>

                 
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<?php require('includes/footer.php'); ?>
