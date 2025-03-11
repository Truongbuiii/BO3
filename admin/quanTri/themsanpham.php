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
                                <h1 class="h4 text-gray-900 mb-4">Thêm sản phẩm</h1>
                            </div>
                <form class="user">
                            <div class="form-group">
                                <label class=""form-label>Tên sản phẩm</label>
                                <input type="text" class="form-control form-control-user"
                                    id="name" aria-describedby="name"
                                    placeholder="Hãy nhập tên sản phẩm">
                            </div>
                            <div class="form-group">
                               <label for="loaimay">Loại máy</label>
                <select class= "form-control" id="loaimay" name="loaimay" required>
                    <option value="" disabled selected> --Chọn loại máy--</option>
                    <option value="1">Quartz (Máy pin - điện tử)</option>
                    <option value="2">Mechanical Movement (Máy cơ)</option>
                </select>
                            </div>
                           
                            <div class="form-group">
                               <label for="loaimay">Loại máy</label>
                <select class= "form-control" id="tinhtrang" name="tinhtrang" required>
                    <option value="" disabled selected> --Chọn tình trạng--</option>
                    <option value="1">Sắn hàng</option>
                    <option value="2">Không sẵn hàng</option>
                </select>
                            </div>
                            <div class="form-group">
                                <label class="price"form-label>Giá</label>
                                <input type="text" class="form-control form-control-user"
                                    id="price" aria-describedby="price"
                                    placeholder="Hãy nhập giá sản phẩm">
                            </div>

<div class="form-group">
    <label class="form-label">Hình ảnh</label>
    <input type="file" class="form-control" id="pic" name="HinhAnh" accept="image/*" onchange="previewImage(event)">
</div>
<!-- Khu vực hiển thị ảnh -->
<img id="imagePreview" src="" alt="Hình ảnh sẽ hiển thị tại đây" style="display: none; width: 150px; margin-top: 10px; border: 1px solid #ccc; padding: 5px;">

            <div class="form-group">
                            <label for="danhmuc">Danh mục</label>
                            <select class= "form-control" id="danhmuc" name="danhmuc" required onchange="coDuongKinh()" >
                                <option value="" disabled selected> --Chọn danh mục đồng hồ--</option>
                   
                            </select>
                                        </div>
                  
                           <button class="btn btn-primary">Thêm mới</button>
                        </form>
                <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.html">Already have an account? Login!</a>
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

