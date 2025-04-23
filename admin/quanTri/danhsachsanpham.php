<?php require('includes/header.php'); ?>

<style>
    .custom-btn {
    background-color: #ffebf0; /* Màu hồng nhạt nhẹ nhàng */
    color:rgba(241, 56, 56, 0.84); /* Màu chữ hồng đậm */
    border: 2px solid rgba(241, 56, 56, 0.84); /* Viền hồng đậm */
    padding: 8px 15px;
    border-radius: 12px; /* Bo góc mềm mại */
    font-weight: bold;
    margin-bottom: 15px;
    transition: all 0.3s ease-in-out; /* Hiệu ứng chuyển đổi mượt mà */
}

.custom-btn:hover {
    background-color: rgba(241, 56, 56, 0.84); /* Màu hồng đậm khi hover */
    color: white; /* Màu chữ trắng */
    border-color: #ffebf0; /* Viền đổi sang hồng nhạt */
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.4); /* Hiệu ứng đổ bóng */
}

</style>

<div>
  <h3>Trang danh sách sản phẩm</h3>
    <a href="themsanpham.php" class="btn btn-primary mb-3">
    <i class="fas fa-user-plus"></i> Thêm sản phẩm
</a>

<?php

require("./db/connect.php"); // Đảm bảo file kết nối đúng

$sql = "SELECT SanPham.MaSanPham, SanPham.TenSanPham, LoaiSanPham.TenLoai, 
               SanPham.HuongVi, SanPham.TinhTrang, SanPham.DonGia, SanPham.HinhAnh
        FROM SanPham
        JOIN LoaiSanPham ON SanPham.MaLoai = LoaiSanPham.MaLoai"; // Sửa lỗi JOIN

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn)); // Kiểm tra lỗi truy vấn
}
?>



<!-- DataTales Example -->
<div class="card shadow mb-4">
   
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Loại kem</th>
            <th>Hương Vị kem</th>
            <th>Tình trạng</th>
            <th>Đơn giá</th>
            <th>Hình ảnh</th>
            <th>Chức năng</th>
            <th>Ẩn/Hiện</th> <!-- Cột ẩn/hiện -->
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Loại kem</th>
            <th>Hương Vị kem</th>
            <th>Tình trạng</th>
            <th>Đơn giá</th>
            <th>Hình ảnh</th>
            <th>Chức năng</th>
            <th>Ẩn/Hiện</th> <!-- Cột ẩn/hiện -->
        </tr>
    </tfoot>
    <tbody>
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr id='product-{$row['MaSanPham']}'>
                    <td>{$row['MaSanPham']}</td>
                    <td>{$row['TenSanPham']}</td>
                    <td>{$row['TenLoai']}</td>
                    <td>{$row['HuongVi']}</td>
                    <td>" . ($row['TinhTrang'] ? "<span class='text-success'>Mở</span>" : "<span class='text-danger'>Khóa</span>") . "</td>
                    <td>" . number_format($row['DonGia'], 0, ',', '.') . " VND</td>
                    <td><img src='../../images/{$row['HinhAnh']}' width='100'></td>
                    <td>
                        <button class='btn btn-warning btn-sm edit-btn' 
                                data-id='{$row['MaSanPham']}' 
                                data-ten='{$row['TenSanPham']}' 
                                data-loai='{$row['TenLoai']}' 
                                data-huongvi='{$row['HuongVi']}' 
                                data-tinhtrang='{$row['TinhTrang']}' 
                                data-gia='{$row['DonGia']}'
                                data-hinh='{$row['HinhAnh']}'
                                data-toggle='modal' 
                                data-target='#editModal'>Sửa</button>

                        <button class='btn btn-danger btn-sm delete-btn' 
                                data-id='{$row['MaSanPham']}' 
                                data-toggle='modal' 
                                data-target='#deleteModal'>Xóa</button>
                    </td>
                    <td><button class='btn btn-info btn-sm toggle-visibility' data-id='{$row['MaSanPham']}'>Ẩn</button></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9' class='text-center'>Không có sản phẩm nào</td></tr>";
    }
    ?>
    </tbody>
</table>

        </div>
    </div>
  </div>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> 
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Chỉnh sửa sản phẩm</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editForm" method="POST" action="suaSanPham.php" enctype="multipart/form-data">
            <!-- Input ẩn để truyền ID sản phẩm -->
            <input type="hidden" id="edit-id" name="MaSanPham">

            <!-- Chia thành 2 cột -->
            <div class="row">
              <!-- Cột 1 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit-ten">Tên sản phẩm</label>
                  <input type="text" class="form-control" id="edit-ten" name="TenSanPham" required>
                </div>

                <div class="form-group">
                  <label for="edit-loai">Loại kem</label>
                  <select class="form-control" id="edit-loai" name="MaLoai">
                    <?php
                    require('./db/connect.php');
                    $loaiQuery = "SELECT MaLoai, TenLoai FROM LoaiSanPham";
                    $loaiResult = mysqli_query($conn, $loaiQuery);
                    while ($loai = mysqli_fetch_assoc($loaiResult)) {
                      echo "<option value='{$loai['MaLoai']}'>{$loai['TenLoai']}</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="edit-huongvi">Hương vị</label>
                  <input type="text" class="form-control" id="edit-huongvi" name="HuongVi" required>
                </div>
              </div>

              <!-- Cột 2 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit-tinhtrang">Tình trạng</label>
                  <select class="form-control" id="edit-tinhtrang" name="TinhTrang">
                    <option value="1">Còn hàng</option>
                    <option value="0">Hết hàng</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="edit-gia">Giá (VND)</label>
                  <input type="number" class="form-control" id="edit-gia" name="DonGia" required>
                </div>

                <div class="form-group">
                  <label for="edit-hinh">Hình ảnh</label>
                  <img id="edit-hinh-preview" src="" width="200" class="mb-4" alt="Preview image">
                  <input type="file" class="form-control-file" id="edit-hinh" name="HinhAnh" style="display:none;">
                <input type="hidden" name="HinhAnh_cu" id="edit-hinh-cu">
                  <button type="button" class="btn btn-secondary" id="change-image-btn">Thay ảnh</button>
                  <small class="form-text text-muted">Chọn hình ảnh mới nếu bạn muốn thay đổi.</small>
                </div>
              </div>
            </div>
            <!-- Kết thúc chia cột -->

            <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
          </form>
        </div>
      </div>
    </div>
  </div>



<script>
  // Khi nhấn vào nút "Thay ảnh", kích hoạt input file
  document.getElementById('change-image-btn').addEventListener('click', function() {
    document.getElementById('edit-hinh').click();
  });

  // Khi chọn hình ảnh, hiển thị ảnh preview
  document.getElementById('edit-hinh').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        document.getElementById('edit-hinh-preview').src = event.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút "Ẩn/Hiện"
    const toggleButtons = document.querySelectorAll('.toggle-visibility');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productRow = document.getElementById('product-' + productId);

            // Kiểm tra trạng thái hiển thị hiện tại
            if (productRow.style.display === 'none') {
                // Hiện lại sản phẩm
                productRow.style.display = 'table-row';
                this.textContent = 'Ẩn'; // Cập nhật lại nút thành "Ẩn"
            } else {
                // Ẩn sản phẩm
                productRow.style.display = 'none';
                this.textContent = 'Hiện lại'; // Cập nhật lại nút thành "Hiện lại"
            }
        });
    });
});


</script>

      </div>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn xóa sản phẩm này không?
      </div>
      <div class="modal-footer">
        <form id="deleteForm" method="POST" action="xoaSanPham.php">
          <input type="hidden" id="delete-id" name="id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-danger">Xóa</button>
        </form>
      </div>
    </div>
  </div>
</div>



   <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("edit-id").value = this.dataset.id;
                document.getElementById("edit-ten").value = this.dataset.ten;
                document.getElementById("edit-gia").value = this.dataset.gia;
                document.getElementById("edit-huongvi").value = this.dataset.huongvi;
                document.getElementById("edit-hinh-preview").src = "../../images/" + this.dataset.hinh;
                document.getElementById("edit-hinh-cu").value = this.dataset.hinh;


                // Set selected Loại kem
                let loaiSelect = document.getElementById("edit-loai");
                for (let option of loaiSelect.options) {
                    if (option.text === this.dataset.loai) {
                        option.selected = true;
                        break;
                    }
                }

                // Set selected Tình trạng
                let tinhTrangSelect = document.getElementById("edit-tinhtrang");
                for (let option of tinhTrangSelect.options) {
                    if (option.value === this.dataset.tinhtrang) {
                        option.selected = true;
                        break;
                    }
                }
            });
        });
    });

document.querySelectorAll(".delete-btn").forEach(button => {
    button.addEventListener("click", function() {
        document.getElementById("delete-id").value = this.dataset.id;
    });
});



</script>



<?php require('includes/footer.php'); ?>
