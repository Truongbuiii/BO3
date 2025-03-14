<?php 
    require('includes/header.php');
?>
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
                        <form class="user">
                            <!-- Mã khách hàng -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputMaKH" name="maKH"
                                    placeholder="Mã khách hàng">
                            </div>
                            <!-- Họ và Tên -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputHovaten" name="hoTen"
                                    placeholder="Họ và Tên">
                            </div>
                            <!-- Ngày sinh và Giới tính -->
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="date" class="form-control form-control-user" id="exampleNgaySinh" name="ngaySinh"
                                        placeholder="Ngày Sinh">
                                </div>
                                <!-- Giới tính -->
<div class="col-sm-6">
    <select class="form-control form-control-user" id="gender" name="gioiTinh">
        <option value="">Chọn giới tính</option>
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
        <option value="Khác">Khác</option>
    </select>
</div>
                            </div>
                            <!-- Địa chỉ -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleDiaChi" name="diaChi"
                                    placeholder="Địa chỉ">
                            </div>
                            <!-- Số điện thoại -->
                            <div class="form-group">
                                <input type="tel" class="form-control form-control-user" id="exampleSDT" name="soDienThoai"
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
    <select class="form-control form-control-user" id="chucNang" name="chucNang">
        <option value="">Chọn chức năng</option>
        <option value="admin">Quản trị viên</option>
        <option value="user">Người dùng</option>
    </select>
</div>

                            <!-- Nút đăng ký -->
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Đăng ký tài khoản
                            </button>
                          
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Quên mật khẩu?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.html">Bạn đã có tài khoản? Đăng nhập!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    require('includes/footer.php'); 
?>
