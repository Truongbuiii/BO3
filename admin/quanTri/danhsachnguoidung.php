<?php 
    require('includes/header.php');
?>
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

        // Thêm class cho cả dòng nếu bị khóa
$rowClass = ($row['TinhTrang'] == 'Khóa') ? 'table-warning' : '';

        echo "<tr class='{$rowClass}'>
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
                <button class='btn btn-warning btn-sm rounded-pill px-2' 
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
                    <select id="editTinhTrang" name="TinhTrang" class="form-control" onchange="updateTinhTrangColor()">
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
            <option value="Quận 10">Quận 10</option>
            <option value="Quận 11">Quận 11</option>
            <option value="Quận 12">Quận 12</option>
            <option value="Quận Tân Phú">Quận Tân Phú</option>
            <option value="Quận Gò Vấp">Quận Gò Vấp</option>
            <option value="Quận Bình Thạnh">Quận Bình Thạnh</option>
            <option value="Quận Phú Nhuận">Quận Phú Nhuận</option>
            <option value="Quận Tân Bình">Quận Tân Bình</option>
            <option value="Quận Bình Tân">Quận Bình Tân</option>
            <option value="Thành phố Thủ Đức">Thành Phố Thủ Đức</option>
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



    .tinhtrang-mo {
            color: green;
            font-weight: bold;
        }
        .tinhtrang-khoa {
            color: red;
            font-weight: bold;
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
        "Quận 1": ["Phường Tân Định", "Phường Đa Kao", "Phường Bến Nghé", "Phường Bến Thành", "Phường Nguyễn Thái Bình", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Nguyễn Cư Trinh", "Phường Phạm Ngũ Lão", "Phường Cầu Kho"],
            "Quận 2":[ "Phường An Khánh", "Phường An Phú","Phường Tân Phú", "Phường Cát Lái", "Phường Thảo Điền", "Phường Thủ Thiêm"],
            "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường Võ Thị Sáu"],
            "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 6", "Phường 8", "Phường 9", "Phường 10", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 18"],
            "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
            "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
            "Quận 7": ["Phường Tân Thuận Đông", "Phường Tân Thuận Tây", "Phường Tân Kiểng", "Phường Tân Hưng", "Phường Tân Phong", "Phường Tân Phú", "Phường Phú Mỹ", "Phường Phú Thuận", "Phường Bình Thuận", "Phường Tân Quy"],
            "Quận 8": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
            "Quận 10": ["Phường 1", "Phường 2", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
            "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
            "Quận 12": ["Phường An Phú Đông", "Phường Đông Hưng Thuận", "Phường Hiệp Thành", "Phường Tân Chánh Hiệp", "Phường Tân Hưng Thuận", "Phường Tân Thới Hiệp", "Phường Tân Thới Nhất", "Phường Thạnh Lộc", "Phường Thạnh Xuân", "Phường Thới An", "Phường Trung Mỹ Tây"],
            "Quận Bình Tân": ["Phường An Lạc", "Phường An Lạc A", "Phường Bình Hưng Hòa", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B", "Phường Bình Trị Đông", "Phường Bình Trị Đông A", "Phường Bình Trị Đông B", "Phường Tân Tạo", "Phường Tân Tạo A"],
            "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"],
            "Quận Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 17"],
            "Quận Phú Nhuận": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 13", "Phường 15", "Phường 17"],
            "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
            "Quận Tân Phú": ["Phường Hiệp Tân", "Phường Hòa Thạnh", "Phường Phú Thạnh", "Phường Phú Thọ Hòa", "Phường Phú Trung", "Phường Sơn Kỳ", "Phường Tân Quý", "Phường Tân Sơn Nhì", "Phường Tân Thành", "Phường Tây Thạnh"],
            "Thành phố Thủ Đức": ["Phường Hiệp Bình Chánh", "Phường Hiệp Bình Phước", "Phường Linh Chiểu", "Phường Linh Đông", "Phường Linh Tây", "Phường Linh Trung", "Phường Linh Xuân", "Phường Bình Chiểu", "Phường Bình Thọ", "Phường Tam Bình", "Phường Tam Phú", "Phường Trường Thọ", "Phường Bình An", "Phường Bình Trưng Đông", "Phường Bình Trưng Tây", "Phường Phước Long A", "Phường Phước Long B", "Phường Tăng Nhơn Phú A", "Phường Tăng Nhơn Phú B", "Phường Phước Bình", "Phường Tân Phú", "Phường Trường Thạnh", "Phường Long Thạnh Mỹ", "Phường Long Phước", "Phường Long Trường", "Phường Phú Hữu", "Phường Thạnh Mỹ Lợi"],
            "Huyện Nhà Bè": ["Xã Phước Kiển", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức"]
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

    tinhTrangSelect.classList.remove('border-success', 'border-danger');

    if (tinhTrang === 'Khóa') {
        tinhTrangSelect.classList.add('border-danger');
        lockUserFields();
    } else {
        tinhTrangSelect.classList.add('border-success');
        unlockUserFields();
    }

    updateTinhTrangColor(); // Gọi lại để chắc chắn
}

   function updateTinhTrangColor() {
    const select = document.getElementById("editTinhTrang");
    const selectedValue = select.value;

    // Reset tất cả border cũ
    select.classList.remove("border-success", "border-danger");

    // Thêm border mới dựa vào giá trị
    if (selectedValue === "Mở") {
        select.classList.add("border-success");
    } else if (selectedValue === "Khóa") {
        select.classList.add("border-danger");
    }
}


    // Gọi lại hàm khi mở popup để cập nhật đúng màu ban đầu
    document.addEventListener("DOMContentLoaded", function () {
        updateTinhTrangColor();
    });


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
