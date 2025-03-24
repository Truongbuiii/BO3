<?php 
 require('includes/header.php');
  ?>

<div class="container">

       <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Thêm sản phẩm</h1>
        </div>
        <form class="user">
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" placeholder="Hãy nhập tên sản phẩm">
            </div>

            <div class="form-group">
                <label for="loaiKem">Loại Kem</label>
                <select class="form-control" id="loaiKem"  name="loaiKem">
                    <option value="" disabled selected>Chọn loại kem</option>
                    <option value="que">Kem que</option>
                    <option value="ocQue">Kem ốc quế</option>
                    <option value="ly">Kem ly</option>
                </select>
            </div>

            <div class="form-group">
                <label for="huongVi">Hương vị</label>
                <input type="text" class="form-control" id="huongVi" placeholder="Hãy nhập hương vị">
            </div>

            <div class="form-group">
                <label for="tinhTrang">Tình trạng</label>
                <select class="form-control" id="tinhTrang" name="tinhTrang">
                    <option value="" disabled selected>Chọn tình trạng</option>
                    <option value="1">Sẵn hàng</option>
                    <option value="2">Không sẵn hàng</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Đơn giá</label>
                <input type="text" class="form-control" id="price" placeholder="Hãy nhập giá sản phẩm">
            </div>
<div class="form-group">
    <label for="pic" class="form-label">Hình ảnh</label>
    
    <!-- Nút chọn tệp tùy chỉnh -->
    <label for="pic" class="custom-file-upload">
        📁 Chọn tệp
    </label>
    <input type="file" id="pic" name="HinhAnh" accept="image/*" onchange="previewImage(event)">

    <!-- Hiển thị tên file được chọn -->
    <span id="file-name">Chưa có tệp nào</span>
</div>

<!-- Khu vực hiển thị ảnh xem trước -->
<img id="imagePreview" src="" alt="Hình ảnh sẽ hiển thị tại đây">


            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </form>
    </div>
</div>


    </div>

         
   <?php 
   require('includes/footer.php'); 
   ?>

