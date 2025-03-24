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
                        <form class="user" onsubmit="return validateForm();">
                            <!-- Mã khách hàng -->
                            <div class="form-group">
                        <label for="maKhachHang">Mã khách hàng</label>
                                <input type="text" class="form-control form-control-user" id="exampleInputMaKH" name="maKH"
                                    placeholder="Hãy nhập khách hàng">
                            </div>
                            <!-- Họ và Tên -->
                            <div class="form-group">
                                <label for="tenDangNhap">Tên đăng nhập (Email)</label>
                                <input type="text" class="form-control form-control-user" id="exampleInputHovaten" name="hoTen"
                                    placeholder="Hãy nhập tên đăng nhập (Email)">
                            </div>
                    
                            <!-- Địa chỉ -->
                            <div class="form-group">
                                <label for="Địa chỉ"></label>
                                <input type="text" class="form-control form-control-user" id="exampleDiaChi" name="diaChi"
                                    placeholder="Địa chỉ">
                            </div>
                            <!-- Số điện thoại -->
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="exampleSDT" name="soDienThoai"
                                    placeholder="Số điện thoại">
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email"
                                    placeholder="Email">
                            </div>
                            <!-- Mật khẩu và Nhập lại mật khẩu -->
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="matKhau"
                                        placeholder="Mật khẩu">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" name="nhapLaiMatKhau"
                                        placeholder="Nhập lại mật khẩu">
                                </div>
                            </div>
                            <!-- Chức năng -->
                            <div class="form-group">
                                <select class="form-control" id="chucNang" name="chucNang">
                                    <option value="">Chọn vai trò</option>
                                    <option value="admin">Quản trị viên (Admin)</option>
                                    <option value="user">Người dùng (User)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <lebel></lebel>
                            </div>
                            <!-- Nút đăng ký -->
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Đăng ký tài khoản
                            </button>
                        </form>
                        <div class="text-center">
                            <a class="small" href="login.html">Bạn đã có tài khoản? Đăng nhập!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript kiểm tra form -->
<script>
    function validateForm() {
        const maKH = document.getElementById("exampleInputMaKH").value.trim();
        const hoTen = document.getElementById("exampleInputHovaten").value.trim();
        const ngaySinh = document.getElementById("exampleNgaySinh").value.trim();
        const gioiTinh = document.getElementById("gender").value.trim();
        const diaChi = document.getElementById("exampleDiaChi").value.trim();
        const soDienThoai = document.getElementById("exampleSDT").value.trim();
        const email = document.getElementById("exampleInputEmail").value.trim();
        const matKhau = document.getElementById("exampleInputPassword").value;
        const nhapLaiMatKhau = document.getElementById("exampleRepeatPassword").value;
        const chucNang = document.getElementById("chucNang").value.trim();

        // Biểu thức chính quy kiểm tra số điện thoại (bắt đầu bằng 0, độ dài 10-11 số)
        const phoneRegex = /^0[0-9]{9,10}$/;
        // Biểu thức chính quy kiểm tra email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Kiểm tra nhập đầy đủ
        if (!maKH || !hoTen || !ngaySinh || !gioiTinh || !diaChi || !soDienThoai || !email || !matKhau || !nhapLaiMatKhau || !chucNang) {
            alert("Vui lòng nhập đầy đủ thông tin!");
            return false;
        }

        // Kiểm tra định dạng số điện thoại
        if (!phoneRegex.test(soDienThoai)) {
            alert("Số điện thoại không hợp lệ! Số điện thoại phải bắt đầu bằng số 0 và có độ dài 10-11 chữ số.");
            return false;
        }

        // Kiểm tra định dạng email
        if (!emailRegex.test(email)) {
            alert("Địa chỉ email không hợp lệ!");
            return false;
        }

        // Kiểm tra khớp mật khẩu
        if (matKhau !== nhapLaiMatKhau) {
            alert("Mật khẩu và nhập lại mật khẩu không khớp!");
            return false;
        }

        alert("Đăng ký thành công!");
        return true;
    }
</script>

<?php 
    require('includes/footer.php'); 
?>
