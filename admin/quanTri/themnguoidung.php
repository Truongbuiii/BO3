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
                            <!-- Mã người dùng -->
                            <div class="form-group">
                        
                            <!-- Tên nguoidung-->
                            <div class="form-group">
                                <label for="tenDangNhap">Tên đăng nhập </label>
                                <input type="text" class="form-control form-control-user" id="tenDangNhap" name="tenDangNhap"
                                    >
                            </div>  
                            <!-- Ho va ten -->
                             <div class="form-group">
                                <label for="hoVaTen">Họ và tên</label>
                             <input type="text" class="form-control form-control-user" id ="hoVaTen" name="hoVaTen">
                            </div>
                    
                            <!-- Địa chỉ -->
                          <div class="form-group">
                                <label for="tinh">Tỉnh/Thành phố</label>
                                <select class="form-control" id="tinh" onchange="loadHuyen()">
                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="huyen">Quận/Huyện</label>
                                <select class="form-control" id="huyen" onchange="loadXa()" disabled>
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="xa">Phường/Xã</label>
                                <select class="form-control" id="xa" disabled>
                                    <option value="">Chọn Phường/Xã</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="diaChi">Địa chỉ cụ thể</label>
                                <input type="text" class="form-control" id="diaChi" >
                            </div>

                            <!-- Số điện thoại -->
                            <div class="form-group">
                                <label class="soDienThoai">Số điện thoại</label>
                                <input type="number" class="form-control form-control-user" id="soDienThoai" name="soDienThoai"
                                   >
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <label class="email">Email</label>
                                <input type="email" class="form-control form-control-user" id="email" name="email"
                                   >
                            </div>
                            <!-- Mật khẩu và Nhập lại mật khẩu -->
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="matKhau">Mật khẩu</label>
                                    <input type="password" class="form-control form-control-user" id="password1" name="matKhau"
                                       >
                                </div>
                                <div class="col-sm-6">
                                    <label class="matKhau2">Nhập lại mật khẩu</label>
                                    <input type="password" class="form-control form-control-user" id="password2" name="nhapLaiMatKhau"
                                      >
                                </div>
                            </div>
                            <!-- Chức năng -->
                            <div class="form-group">
                                <label class="vaiTro">Vai trò</label>
                                <select class="form-control" id="vaiTro" name="vaiTro">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    require('includes/footer.php'); 
?>
