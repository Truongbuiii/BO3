<?php 
    require('includes/header.php');
?>
<style>
    #gender, #chucNang {
        border-radius: 25px;
        padding: 10px 15px;
        height: 50px;
        border: 1px solid #ced4da;
    }
</style>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Tạo tài khoản!</h1>
                        </div>
                    <form class="user" action="xulydangky.php" method="POST" onsubmit="return validateForm();">
    <!-- Mã người dùng -->
    <div class="form-group">
        <!-- Tên người dùng -->
        <div class="form-group">
            <label for="TenNguoiDung">Tên người dùng</label>
            <input type="text" class="form-control form-control-user" id="TenNguoiDung" name="TenNguoiDung" placeholder="Nhập tên đăng nhập" required>
        </div>  

        <!-- Họ và tên -->
        <div class="form-group">
            <label for="HoTen">Họ và tên</label>
            <input type="text" class="form-control form-control-user" id="HoTen" name="HoTen" placeholder="Nhập họ và tên" required>
        </div>

        <!-- Địa chỉ -->
        <div class="form-group">
            <label for="tinh">Tỉnh/Thành phố</label>
            <select class="form-control" id="tinh" name="tinh" onchange="loadHuyen()" required>
                <option value="">Chọn Tỉnh/Thành phố</option>
            </select>
        </div>

        <div class="form-group">
            <label for="huyen">Quận/Huyện</label>
            <select class="form-control" id="huyen" name="huyen" onchange="loadXa()" disabled required>
                <option value="">Chọn Quận/Huyện</option>
            </select>
        </div>

        <div class="form-group">
            <label for="xa">Phường/Xã</label>
            <select class="form-control" id="xa" name="xa" disabled required>
                <option value="">Chọn Phường/Xã</option>
            </select>
        </div>

        <div class="form-group">
            <label for="diaChi">Địa chỉ cụ thể</label>
            <input type="text" class="form-control" id="diaChi" name="diaChi" placeholder="Nhập địa chỉ cụ thể" required>
        </div>

        <!-- Số điện thoại -->
        <div class="form-group">
            <label class="soDienThoai">Số điện thoại</label>
            <input type="tel" class="form-control form-control-user" id="soDienThoai" name="soDienThoai" placeholder="Nhập số điện thoại" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label class="email">Email</label>
            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Nhập email" required>
        </div>

        <!-- Mật khẩu và Nhập lại mật khẩu -->
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label class="matKhau">Mật khẩu</label>
                <input type="password" class="form-control form-control-user" id="password1" name="matKhau" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="col-sm-6">
                <label class="matKhau2">Nhập lại mật khẩu</label>
                <input type="password" class="form-control form-control-user" id="password2" name="nhapLaiMatKhau" placeholder="Nhập lại mật khẩu" required>
            </div>
        </div>

        <!-- Chức năng -->
        <div class="form-group">
            <label class="vaiTro">Vai trò</label>
            <select class="form-control" id="vaiTro" name="vaiTro" required>
                <option value="">Chọn vai trò</option>
                <option value="admin">Quản trị viên (Admin)</option>
                <option value="Customer">Người dùng (Customer)</option>
            </select>
        </div>

        <!-- Nút đăng ký -->
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Đăng ký tài khoản
        </button>
    </form>


    <script>
        function validateForm() {
    var password1 = document.getElementById("password1").value;
    var password2 = document.getElementById("password2").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("soDienThoai").value;
    var tinh = document.getElementById("tinh").value;
    var huyen = document.getElementById("huyen").value;
    var xa = document.getElementById("xa").value;
    var diaChi = document.getElementById("diaChi").value;

    // Kiểm tra xem mật khẩu có bị bỏ trống không
    if (password1 === "" || password2 === "") {
        alert("Vui lòng nhập đầy đủ mật khẩu!");
        return false;
    }

    // Kiểm tra mật khẩu có khớp không
    if (password1 !== password2) {
        alert("Mật khẩu nhập lại không khớp!");
        return false;
    }

    // Kiểm tra định dạng email
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Vui lòng nhập một địa chỉ email hợp lệ!");
        return false;
    }

    // Kiểm tra định dạng số điện thoại
    var phonePattern = /^[0-9]{10,11}$/; // Điều chỉnh pattern theo yêu cầu
    if (!phonePattern.test(phone)) {
        alert("Vui lòng nhập số điện thoại hợp lệ!");
        return false;
    }

    // Kiểm tra các trường chưa điền đầy đủ
    if (tinh === "" || huyen === "" || xa === "" || diaChi === "") {
        alert("Vui lòng điền đầy đủ địa chỉ!");
        return false;
    }

    // Kiểm tra nếu trường vai trò chưa chọn
    var vaiTro = document.getElementById("vaiTro").value;
    if (vaiTro === "") {
        alert("Vui lòng chọn vai trò!");
        return false;
    }

    // Kiểm tra các trường bắt buộc khác đã điền chưa
    var requiredFields = document.querySelectorAll('[required]');
    for (var i = 0; i < requiredFields.length; i++) {
        if (requiredFields[i].value.trim() === "") {
            alert("Vui lòng điền đầy đủ thông tin!");
            return false;
        }
    }

    // Nếu tất cả các kiểm tra đều hợp lệ, cho phép gửi form
    return true;
}



    </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    require('includes/footer.php'); 
?>
