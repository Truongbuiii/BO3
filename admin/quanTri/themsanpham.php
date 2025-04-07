<?php
require 'includes/header.php';
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Thêm sản phẩm</h1>
            </div>
            <form class="user" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="tenSanPham" placeholder="Hãy nhập tên sản phẩm" required>
                </div>

                <div class="form-group">
                    <label for="loaiKem">Loại Kem</label>
                    <select class="form-control" id="loaiKem" name="loaiKem" required>
                        <option value="" disabled selected>Chọn loại kem</option>
                        <option value="que">Kem que</option>
                        <option value="ocQue">Kem ốc quế</option>
                        <option value="ly">Kem ly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="huongVi">Hương vị</label>
                    <input type="text" class="form-control" id="huongVi" name="huongVi" placeholder="Hãy nhập hương vị" required>
                </div>

                <div class="form-group">
                    <label for="tinhTrang">Tình trạng</label>
                    <select class="form-control" id="tinhTrang" name="tinhTrang" required>
                        <option value="" disabled selected>Chọn tình trạng</option>
                        <option value="1">Sẵn hàng</option>
                        <option value="2">Không sẵn hàng</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="text" class="form-control" id="price" name="gia" placeholder="Hãy nhập giá sản phẩm" required>
                </div>

                <div class="form-group">
                    <label for="pic">Hình ảnh</label>
                    <input type="file" class="form-control" id="pic" name="HinhAnh" accept="image/*">
                    <span id="file-name">Chưa có tệp nào</span>
                </div>

                <!-- Khu vực hiển thị ảnh -->
                <img id="imagePreview" src="" alt="Hình ảnh sẽ hiển thị tại đây" style="display: none; width: 150px; margin-top: 10px; border: 1px solid #ccc; padding: 5px;">

                <button class="btn btn-primary mt-3" type="submit">Thêm mới</button>
            </form>
        </div>
    </div>
</div>

<?php
require 'includes/footer.php';
?>
