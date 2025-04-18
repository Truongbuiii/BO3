<?php require('includes/header.php'); ?>
<div>
  <h3>Trang danh sách người dùng</h3>

  <?php
  require("./db/connect.php");

  $sql = "SELECT TenNguoiDung, HoTen, Email, MatKhau ,SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe
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
                                                    <th>Mật khẩu</th>
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
        // Rút gọn mật khẩu
        $matKhauRutGon = substr($row['MatKhau'], 0, 3) . str_repeat('*', 5);

        echo "<tr>
            <td>{$row['TenNguoiDung']}</td>
            <td>{$row['HoTen']}</td>
            <td>{$row['Email']}</td>
            <td>{$matKhauRutGon}</td>
            <td>{$row['SoDienThoai']}</td>
            <td>{$row['VaiTro']}</td>
            <td>{$row['TinhTrang']}</td>
            <td>{$row['TPTinh']}</td>
            <td>{$row['QuanHuyen']}</td>
            <td>{$row['PhuongXa']}</td>
            <td>{$row['DiaChiCuThe']}</td>
            <td>
                <button class='btn btn-warning btn-sm rounded-pill px-3' 
                    onclick='editUser(
                        \"{$row['TenNguoiDung']}\",
                        \"{$row['HoTen']}\",
                        \"{$row['Email']}\",
                        \"{$row['MatKhau']}\",
                        \"{$row['SoDienThoai']}\",
                        \"{$row['VaiTro']}\",
                        \"{$row['TinhTrang']}\",
                        \"{$row['TPTinh']}\",
                        \"{$row['QuanHuyen']}\",
                        \"{$row['PhuongXa']}\",
                        \"{$row['DiaChiCuThe']}\" 
                    )'>
                    <i class=\"fas fa-edit\"></i> Sửa
                </button>
                <a href='xoaNguoiDung.php?TenNguoiDung={$row['TenNguoiDung']}'
                   class='btn btn-danger btn-sm rounded-pill px-3'
                   onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>
                   <i class=\"fas fa-trash-alt\"></i> Xóa
                </a>
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
<div id="editUserModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <label>Mật khẩu</label>
                            <input type="text" class="form-control" id="editMatKhau" name="MatKhau">
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

                       

                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">

                                    <div class="form-group">
                                    <label>Tình trạng</label>
                                    <select class="form-control" id="editTinhTrang" name="TinhTrang" onchange="handleTinhTrangChange()">
                                        <option value="Mở" class="text-success">Mở</option>
                                        <option value="Khóa" class="text-danger">Khóa</option>
                                    </select>
                                </div>

                                                    <div class="form-group">
                                <label>Tỉnh/Thành phố</label>
                                <input type="text" class="form-control" id="editTPTinh" name="TPTinh">
                            </div>


                            <div class="form-group">
                                <label for="quan">Quận/Huyện</label>
                                <select id="editQuanHuyen" name="QuanHuyen" class="form-control" required>
                                    <option value="">-- Chọn quận/huyện --</option>
                                    <option value="Quận 1">Quận 1</option>
                                    <option value="Quận 3">Quận 3</option>
                                    <option value="Quận 5">Quận 5</option>
                                    <option value="Quận 7">Quận 7</option>
                                    <option value="Bình Thạnh">Bình Thạnh</option>
                                    <option value="Gò Vấp">Gò Vấp</option>
                                    <option value="Tân Bình">Tân Bình</option>
                                    <option value="Thủ Đức">Thủ Đức</option>
                                    <option value="Quận 10">Quận 10</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phuong">Phường/Xã</label>
                                <select id="editPhuongXa" name="PhuongXa" class="form-control" required>
                                    <option value="">-- Chọn phường/xã --</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ cụ thể</label>
                                <textarea class="form-control" id="editDiaChiCuThe" name="DiaChiCuThe" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
    <button type="button" class="btn btn-secondary btn-lg btn-save" onclick="updateUser()">Lưu thay đổi</button>
    <button type="button" class="btn btn-secondary btn-lg btn-cancel" data-bs-dismiss="modal">Hủy</button>
</div>

                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .border-success {
        border: 2px solid #28a745 !important;
    }

    .border-danger {
        border: 2px solid #dc3545 !important;
    }



    .btn-save {
        background-color: #28a745; /* Xanh lá */
        color: white;
        border: none;
    }

    .btn-save:hover {
        background-color: #218838;
    }

    .btn-cancel {
        background-color: #dc3545; /* Đỏ */
        color: white;
        border: none;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }
</style>




<script> 
    

function editUser(TenNguoiDung, HoTen, Email,MatKhau , SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe) {
    document.getElementById('editTenNguoiDung').value = TenNguoiDung;
    document.getElementById('editHoTen').value = HoTen;
    document.getElementById('editEmail').value = Email;
    document.getElementById('editMatKhau').value = MatKhau;
    document.getElementById('editSoDienThoai').value = SoDienThoai;
    document.getElementById('editVaiTro').value = VaiTro;
    document.getElementById('editTinhTrang').value = TinhTrang;
    document.getElementById('editTPTinh').value = TPTinh;
    document.getElementById('editQuanHuyen').value = QuanHuyen;

    // Cập nhật danh sách phường theo quận
    const phuongs = data[QuanHuyen] || [];
    const phuongSelect = document.getElementById('editPhuongXa');
    phuongSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
    phuongs.forEach(phuong => {
        const option = document.createElement('option');
        option.value = phuong;
        option.textContent = phuong;
        phuongSelect.appendChild(option);
    });

    // Sau khi danh sách phường đã đầy đủ, gán giá trị
    document.getElementById('editPhuongXa').value = PhuongXa;

    document.getElementById('editDiaChiCuThe').value = DiaChiCuThe;

    $('#editUserModal').modal('show');
}


function updateUser() {
    const btn = document.querySelector('#editUserForm button');
    btn.disabled = true;
    btn.innerHTML = 'Đang lưu...';

    const tinhTrang = document.getElementById('editTinhTrang').value;

    // Lấy dữ liệu từ form
    var formData = $('#editUserForm').serialize();

    // Nếu tình trạng là "Khóa", chỉ gửi dữ liệu tình trạng
    if (tinhTrang === 'Khóa') {
        formData = $('#editUserForm').find('input, select').filter(function() {
            return this.name === 'TinhTrang'; // Chỉ gửi trường tình trạng
        }).serialize();
    }

    // Gửi AJAX yêu cầu cập nhật
    $.ajax({
        type: 'POST',
        url: 'capNhapNguoiDung.php', // Đảm bảo file PHP xử lý cập nhật
        data: formData,
        success: function(response) {
            alert(response);

            // Nếu tình trạng là "Khóa", disable các trường và ẩn nút xóa
            if (tinhTrang === 'Khóa') {
                const allFields = document.querySelectorAll('#editUserForm input, #editUserForm select, #editUserForm textarea');
                const tinhTrangSelect = document.getElementById('editTinhTrang');

                // Disable tất cả các trường, trừ tình trạng
                allFields.forEach(field => {
                    if (field.id !== 'editTinhTrang') {
                        field.disabled = true;
                    }
                });

                // Ẩn nút xóa tài khoản
                const deleteBtn = document.getElementById('deleteAccountBtn');
                if (deleteBtn) deleteBtn.style.display = 'none';

                // Thêm cảnh báo nếu chưa có
                if (!document.getElementById('khoaWarning')) {
                    const warning = document.createElement('div');
                    warning.id = 'khoaWarning';
                    warning.className = 'alert alert-warning mt-3';
                    warning.innerText = 'Người dùng đã bị khóa. Bạn chỉ có thể thay đổi trạng thái hoặc mở khóa người dùng.';
                    tinhTrangSelect.closest('.form-group').appendChild(warning);
                }

                // Ẩn nút lưu
                btn.style.display = 'none';
            } else {
                // Nếu trạng thái không phải "Khóa", mở lại các trường và hiển thị nút xóa
                const allFields = document.querySelectorAll('#editUserForm input, #editUserForm select, #editUserForm textarea');
                allFields.forEach(field => {
                    field.disabled = false;
                });

                const warning = document.getElementById('khoaWarning');
                if (warning) warning.remove();

                const deleteBtn = document.getElementById('deleteAccountBtn');
                if (deleteBtn) deleteBtn.style.display = 'inline-block';

                btn.style.display = 'inline-block';
            }

            // Đóng modal và reload trang sau khi cập nhật
            $('#editUserModal').modal('hide');
            location.reload(); // Tải lại trang để hiển thị thông tin mới

            btn.disabled = false;
            btn.innerHTML = 'Lưu thay đổi';
        },
        error: function() {
            alert('Có lỗi xảy ra!');
            btn.disabled = false;
            btn.innerHTML = 'Lưu thay đổi';
        }
    });
}



// Kiểm tra khi thay đổi tình trạng
function handleTinhTrangChange() {
    const tinhTrang = document.getElementById('editTinhTrang').value;
    const tinhTrangSelect = document.getElementById('editTinhTrang');

    // Reset màu
    tinhTrangSelect.classList.remove('border-success', 'border-danger', 'text-success', 'text-danger');

    if (tinhTrang === 'Khóa') {
        tinhTrangSelect.classList.add('border-danger', 'text-danger');

        // Disable toàn bộ fields, trừ tình trạng
        const allFields = document.querySelectorAll('#editUserForm input, #editUserForm select, #editUserForm textarea');
        allFields.forEach(field => {
            if (field.id !== 'editTinhTrang') {
                field.disabled = true;
            }
        });

        // Ẩn nút xóa tài khoản
        const deleteBtn = document.getElementById('deleteAccountBtn');
        if (deleteBtn) deleteBtn.style.display = 'none';
    } else {
        tinhTrangSelect.classList.add('border-success', 'text-success');

        // Mở lại các fields
        const allFields = document.querySelectorAll('#editUserForm input, #editUserForm select, #editUserForm textarea');
        allFields.forEach(field => {
            field.disabled = false;
        });

        // Hiển thị lại nút xóa tài khoản
        const deleteBtn = document.getElementById('deleteAccountBtn');
        if (deleteBtn) deleteBtn.style.display = 'inline-block';
    }
}


const data = {
    "Quận 1": ["Bến Nghé", "Bến Thành", "Cầu Ông Lãnh", "Cô Giang", "Nguyễn Thái Bình"],
    "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
    "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
    "Quận 7": ["Tân Phong", "Tân Hưng", "Bình Thuận", "Phú Mỹ", "Tân Kiểng", "Tân Quy"],
    "Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 8"],
    "Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8"],
    "Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
    "Thủ Đức": ["Bình Chiểu", "Bình Thọ", "Hiệp Bình Chánh", "Hiệp Phú", "Linh Chiểu", "Linh Đông"],
    "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8"]
};

const quanSelect = document.getElementById('editQuanHuyen');
const phuongSelect = document.getElementById('editPhuongXa');

quanSelect.addEventListener('change', function () {
    const selectedQuan = this.value;
    const phuongs = data[selectedQuan] || [];

    phuongSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';

    phuongs.forEach(phuong => {
        const option = document.createElement('option');
        option.value = phuong;
        option.textContent = phuong;
        phuongSelect.appendChild(option);
    });
});
</script>


<?php require('includes/footer.php'); ?>



<!-- jQuery (nếu dùng Bootstrap 4 hoặc thấp hơn) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper (nếu dùng Bootstrap 4) -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
