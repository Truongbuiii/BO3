<?php require('includes/header.php'); ?>
<div>
  <h3>Trang danh sách người dùng</h3>

  <?php
  require("./db/connect.php");

  $sql = "SELECT TenNguoiDung, HoTen, Email, SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe
          FROM NguoiDung";
  $result = mysqli_query($conn, $sql);
  ?>

  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Danh Sách Người Dùng</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th>Tên người dùng</th>
                          <th>Họ tên</th>
                          <th>Email</th>
                          <th>Số điện thoại</th>
                          <th>Vai trò</th>
                          <th>Tình trạng</th>
                          <th>Tỉnh/Thành phố</th>
                          <th>Quận/Huyện</th>
                          <th>Phường/Xã</th>
                          <th>Địa chỉ cụ thể</th>
                          <th>Chức năng</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<tr>
                                      <td>{$row['TenNguoiDung']}</td>
                                      <td>{$row['HoTen']}</td>
                                      <td>{$row['Email']}</td>
                                      <td>{$row['SoDienThoai']}</td>
                                      <td>{$row['VaiTro']}</td>
                                      <td>{$row['TinhTrang']}</td>
                                      <td>{$row['TPTinh']}</td>
                                      <td>{$row['QuanHuyen']}</td>
                                      <td>{$row['PhuongXa']}</td>
                                      <td>{$row['DiaChiCuThe']}</td>
                                      <td>
                                          <button class='btn btn-warning btn-sm' onclick='editUser(\"{$row['TenNguoiDung']}\", \"{$row['HoTen']}\", \"{$row['Email']}\", \"{$row['SoDienThoai']}\", \"{$row['VaiTro']}\", \"{$row['TinhTrang']}\", \"{$row['TPTinh']}\", \"{$row['QuanHuyen']}\", \"{$row['PhuongXa']}\", \"{$row['DiaChiCuThe']}\")'>Sửa</button>
                                          <a href='delete_user.php?TenNguoiDung={$row['TenNguoiDung']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
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

<!-- Popup Modal Chỉnh Sửa -->
<!-- Popup Modal Chỉnh Sửa -->
<div id="editUserModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa người dùng</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editTenNguoiDung" name="TenNguoiDung">
                    
                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" id="editHoTen" name="HoTen">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="editEmail" name="Email">
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" id="editSoDienThoai" name="SoDienThoai">
                            </div>

                            <div class="form-group">
                                <label>Vai trò</label>
                                <select class="form-control" id="editVaiTro" name="VaiTro">
                                    <option value="Admin">Admin</option>
                                    <option value="Customer">Người dùng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tình trạng</label>
                                <select class="form-control" id="editTinhTrang" name="TinhTrang">
                                    <option value="Mở">Mở</option>
                                    <option value="Khóa">Khóa</option>
                                </select>
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tỉnh/Thành phố</label>
                                <input type="text" class="form-control" id="editTPTinh" name="TPTinh">
                            </div>

                            <div class="form-group">
                                <label>Quận/Huyện</label>
                                <input type="text" class="form-control" id="editQuanHuyen" name="QuanHuyen">
                            </div>

                            <div class="form-group">
                                <label>Phường/Xã</label>
                                <input type="text" class="form-control" id="editPhuongXa" name="PhuongXa">
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ cụ thể</label>
                                <textarea class="form-control" id="editDiaChiCuThe" name="DiaChiCuThe" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="updateUser()">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require('includes/footer.php'); ?>

<script>
function editUser(TenNguoiDung, HoTen, Email, SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe) {
    document.getElementById('editTenNguoiDung').value = TenNguoiDung;
    document.getElementById('editHoTen').value = HoTen;
    document.getElementById('editEmail').value = Email;
    document.getElementById('editSoDienThoai').value = SoDienThoai;
    document.getElementById('editVaiTro').value = VaiTro;
    document.getElementById('editTinhTrang').value = TinhTrang;
    document.getElementById('editTPTinh').value = TPTinh;  // ✅ Sửa lỗi
    document.getElementById('editQuanHuyen').value = QuanHuyen;  // ✅ Sửa lỗi
    document.getElementById('editPhuongXa').value = PhuongXa;  // ✅ Sửa lỗi
    document.getElementById('editDiaChiCuThe').value = DiaChiCuThe;
    
    $('#editUserModal').modal('show');
}


function updateUser() {
    var formData = $('#editUserForm').serialize();
    $.ajax({
        type: 'POST',
        url: 'update_user.php',
        data: formData,
        success: function(response) {
            alert(response);
            location.reload();
        }
    });
}
</script>
