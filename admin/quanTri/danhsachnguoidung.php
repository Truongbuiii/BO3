<?php require('includes/header.php'); ?>
<div>
  <h3>Trang danh sách người dùng</h3>

  <?php
  require("./db/connect.php");

  $sql = "SELECT TenNguoiDung, HoTen, Email, MatKhau ,SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe
          FROM NguoiDung";
  $result = mysqli_query($conn, $sql);
  ?>


<a href="themnguoidung.php" class="btn btn-primary mb-3">
    <i class="fas fa-user-plus"></i> Thêm người dùng
</a>

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

                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                             <div class="form-group">
                                <label>Tên người dùng</label>
                                <input type="text" class="form-control" id="editTenNguoiDung" name="TenNguoiDung" readonly>
                            </div>
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
                                <select class="form-control" id="editVaiTro" name="VaiTro" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Customer">Customer</option>
                                </select>
                            </div>

                       

                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">

                                    <div class="form-group">
                                    <label>Tình trạng</label>
<select id="editTinhTrang" name="TinhTrang" class="form-control" onchange="handleTinhTrangChange()">
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
        <option value="Quận 2">Quận 2</option>   
        <option value="Quận 3">Quận 3</option>
        <option value="Quận 4">Quận 4</option>
        <option value="Quận 5">Quận 5</option>
        <option value="Quận 6">Quận 6</option>
        <option value="Quận 7">Quận 7</option>
        <option value="Quận 8">Quận 8</option>
        <option value="Quận 9">Quận 9</option>
        <option value="Quận 10">Quận 10</option>
        <option value="Quận 11">Quận 11</option>
        <option value="Quận Bình Thạnh">Bình Thạnh</option>
        <option value="Quận Phú Nhuận">Phú Nhuận</option>
        <option value="Quận Tân Bình">Tân Bình</option>
        <option value="Quận Bình Tân">Bình Tân</option>
        <option value="Thành phố Thủ Đức">Thủ Đức</option>
        <option value="Huyện Nhà Bè">Huyện Nhà Bè</option>
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
// --- Dữ liệu quận/phường ---
const data = {
 "Quận 1": ["Phường Cầu Kho","Phường Bến Nghé", "Phường Bến Thành", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Nguyễn Thái Bình"],
  "Quận 2":["Phường An Phú","Phường Tân Bình","Phường Tân Phú"],
    "Quận 3": ["Phường Võ Thị Sáu", "Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7","Phường 14"],
  "Quận 4":["Phường 10","Phường 11","Phường 12","Phường 13"],
    "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 8"],
  "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10"],
  "Quận 7": ["Phường Tân Thuận Tây","Phường Tân Phong", "Phường Tân Hưng", "Phường Bình Thuận", "Phường Phú Mỹ", "Phường Tân Kiểng", "Phường Tân Quy", "Phường Tân Phú"],
"Quận 8":["Phường 11","Phường 15"],
"Quận 9":["Phường Hiệp Phú","Phường Hiệp Bình Chánh","Phường Long Trường"],
  "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8","Phường 9"],
  "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 16", "Phường 7"],
  "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 25", "Phường 6", "Phường 7", "Phường 8"],
  "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
  "Thành phố Thủ Đức": ["Phường Bình Chiểu", "Phường Bình Thọ", "Phường Hiệp Bình Chánh", "Phường Hiệp Phú", "Phường Linh Trung", "Phường Linh Đông"],
  "Quận Bình Tân": ["Phường Bình Hưng Hòa", "Phường Bình Trị Đông", "Phường Tân Tạo", "Phường An Lạc", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B"],
  "Huyện Nhà Bè": ["Xã Phước Kiển", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức"],
  "Quận Phú Nhuận":["Phường 9"]
};


function loadPhuongXa(quanHuyen, selectedPhuongXa = "") {
    const phuongXaSelect = document.getElementById('editPhuongXa');
    phuongXaSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>'; // Reset lại

    if (data[quanHuyen]) {
        data[quanHuyen].forEach(function(phuong) {
            const option = document.createElement('option');
            option.value = phuong;
            option.text = phuong;
            if (phuong === selectedPhuongXa) {
                option.selected = true;
            }
            phuongXaSelect.appendChild(option);
        });
    }
}

// Cập nhật phường/xã khi chọn quận
document.getElementById('editQuanHuyen').addEventListener('change', function() {
    const selectedQuan = this.value;
    loadPhuongXa(selectedQuan); // Cập nhật phường/xã khi thay đổi quận
});

// --- Các hàm xử lý --- 

function updateUser() {
    const formData = {
        TenNguoiDung: document.getElementById('editTenNguoiDung').value,
        HoTen: document.getElementById('editHoTen').value,
        Email: document.getElementById('editEmail').value,
        MatKhau: document.getElementById('editMatKhau').value,
        SoDienThoai: document.getElementById('editSoDienThoai').value,
        VaiTro: document.getElementById('editVaiTro').value,
        TinhTrang: document.getElementById('editTinhTrang').value, // ✅ thêm dòng này
        TPTinh: document.getElementById('editTPTinh').value,
        QuanHuyen: document.getElementById('editQuanHuyen').value,
        PhuongXa: document.getElementById('editPhuongXa').value,
        DiaChiCuThe: document.getElementById('editDiaChiCuThe').value
    };

    fetch('capNhapnguoidung.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // thông báo kết quả
        location.reload(); // reload lại danh sách nếu cần
    })
    .catch(error => console.error('Error:', error));
}


  function handleTinhTrangChange() {
    const tinhTrangSelect = document.getElementById('editTinhTrang');
    const tinhTrang = tinhTrangSelect.value;

    tinhTrangSelect.classList.remove('border-success', 'border-danger', 'text-success', 'text-danger');

    if (tinhTrang === 'Khóa') {
      tinhTrangSelect.classList.add('border-danger', 'text-danger');
      lockUserFields();
    } else {
      tinhTrangSelect.classList.add('border-success', 'text-success');
      unlockUserFields();
    }
  }

  function lockUserFields() {
    const allFields = document.querySelectorAll('#editUserForm input, #editUserForm select, #editUserForm textarea');
    allFields.forEach(field => {
      if (field.id !== 'editTinhTrang') {
        field.disabled = true;
      }
    });

    const deleteBtn = document.getElementById('deleteAccountBtn');
    if (deleteBtn) deleteBtn.style.display = 'none';

    if (!document.getElementById('khoaWarning')) {
      const warning = document.createElement('div');
      warning.id = 'khoaWarning';
      warning.className = 'alert alert-warning mt-3';
      warning.innerText = 'Người dùng đã bị khóa. Bạn chỉ có thể thay đổi trạng thái hoặc mở khóa người dùng.';
      document.getElementById('editTinhTrang').closest('.form-group').appendChild(warning);
    }

    const saveBtn = document.querySelector('#editUserForm button');
    if (saveBtn) saveBtn.style.display = 'none';
  }

  function unlockUserFields() {
    const allFields = document.querySelectorAll('#editUserForm input, #editUserForm select, #editUserForm textarea');
    allFields.forEach(field => {
      field.disabled = false;
    });

    const deleteBtn = document.getElementById('deleteAccountBtn');
    if (deleteBtn) deleteBtn.style.display = 'inline-block';

    const warning = document.getElementById('khoaWarning');
    if (warning) warning.remove();

    const saveBtn = document.querySelector('#editUserForm button');
    if (saveBtn) saveBtn.style.display = 'inline-block';
  }

function editUser(TenNguoiDung, HoTen, Email, MatKhau, SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe) {
   document.getElementById('editTenNguoiDung').value = TenNguoiDung;
    document.getElementById('editHoTen').value = HoTen;
    document.getElementById('editEmail').value = Email;
    document.getElementById('editMatKhau').value = MatKhau;
    document.getElementById('editSoDienThoai').value = SoDienThoai;
    document.getElementById('editVaiTro').value = VaiTro;
    document.getElementById('editTinhTrang').value = TinhTrang;
    document.getElementById('editTPTinh').value = TPTinh;

    // Gán trước Quận/Huyện
    document.getElementById('editQuanHuyen').value = QuanHuyen;

    // Load Phường/Xã theo Quận/Huyện đã chọn
    loadPhuongXa(QuanHuyen, PhuongXa);

    document.getElementById('editDiaChiCuThe').value = DiaChiCuThe;

  $('#editUserModal').modal('show');
}


function updatePhuongXaOptions(quan) {
  const phuongSelect = document.getElementById('editPhuongXa');
  const phuongs = data[quan] || [];

  // Xóa hết các options cũ
  phuongSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';

  // Nếu có phường/xã, thêm vào các lựa chọn
  if (phuongs.length > 0) {
    phuongs.forEach(phuong => {
      const option = document.createElement('option');
      option.value = phuong;
      option.text = phuong;
      phuongSelect.appendChild(option);
    });
  } else {
    console.log('Không có phường/xã cho quận này');
  }
}

document.getElementById('editQuanHuyen').addEventListener('change', function() {
  updatePhuongXaOptions(this.value);
});

alert.log(phuongSelect.options.length); // In ra số lượng options hiện tại

</script>



<?php require('includes/footer.php'); ?>



<!-- jQuery (nếu dùng Bootstrap 4 hoặc thấp hơn) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper (nếu dùng Bootstrap 4) -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
