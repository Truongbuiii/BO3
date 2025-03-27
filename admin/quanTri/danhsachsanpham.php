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
    <div class="themSanPham">
                <a href="themsanpham.php"><button class="btn custom-btn" >Thêm sản phẩm</button></a>
            </div>
<?php

require("./db/connect.php"); // Đảm bảo file kết nối đúng

$sql = "SELECT SanPham.id, SanPham.tenSanPham, LoaiKem.tenLoaiKem, SanPham.huongVi, 
               SanPham.tinhTrang, SanPham.gia, SanPham.hinhAnh, 
               SanPham.soLuongCon, SanPham.soLuongDaBan
        FROM SanPham
        JOIN LoaiKem ON SanPham.LoaiKem = LoaiKem.id"; 

$result = mysqli_query($conn, $sql);
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
                        <th>Diển giải</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
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
                        <th>Diển giải</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['tenSanPham']}</td>
                                    <td> {$row['tenLoaiKem']}</td>
                                    <td>{$row['huongVi']}</td>
                                    <td>{$row['tinhTrang']}</td>
                                    <td>" . number_format($row['gia'], 0, ',', '.') . " VND</td>
   <td><img src='images/{$row['hinhAnh']}' width='100'></td>           
                            <td>{$row['soLuongCon']}</td>
                                    <td>{$row['soLuongDaBan']}</td>
                                    <td>
    <button class='btn btn-warning btn-sm edit-btn' 
            data-id='{$row['id']}' 
            data-ten='{$row['tenSanPham']}' 
            data-loai='{$row['tenLoaiKem']}' 
            data-huongvi='{$row['huongVi']}' 
            data-tinhtrang='{$row['tinhTrang']}' 
            data-gia='{$row['gia']}'
            data-hinh='{$row['hinhAnh']}'
            data-toggle='modal' 
            data-target='#editModal'>Sửa</button>

    <button class='btn btn-danger btn-sm delete-btn' 
            data-id='{$row['id']}' 
            data-toggle='modal' 
            data-target='#deleteModal'>Xóa</button>
</td>

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

<!-- Edit Modal --><!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl"> <!-- Mở rộng modal -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa sản phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm" method="POST" action="editProduct.php">
          <input type="hidden" id="edit-id" name="id">

          <!-- Bắt đầu chia thành 2 cột -->
          <div class="row">
            <!-- Cột 1 -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-ten">Tên sản phẩm</label>
                <input type="text" class="form-control" id="edit-ten" name="tenSanPham" required>
              </div>

              <div class="form-group">
                <label for="edit-loai">Loại kem</label>
                <select class="form-control" id="edit-loai" name="loai">
                  <?php
                  require('./db/connect.php');
                  $loaiQuery = "SELECT id, tenLoaiKem FROM LoaiKem";
                  $loaiResult = mysqli_query($conn, $loaiQuery);
                  while ($loai = mysqli_fetch_assoc($loaiResult)) {
                    echo "<option value='{$loai['id']}'>{$loai['tenLoaiKem']}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="edit-huongvi">Hương vị</label>
                <input type="text" class="form-control" id="edit-huongvi" name="huongvi" required>
              </div>
            </div>

            <!-- Cột 2 -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-tinhtrang">Tình trạng</label>
                <select class="form-control" id="edit-tinhtrang" name="tinhtrang">
                  <option value="Còn hàng">Còn hàng</option>
                  <option value="Hết hàng">Hết hàng</option>
                </select>
              </div>

              <div class="form-group">
                <label for="edit-gia">Giá (VND)</label>
                <input type="number" class="form-control" id="edit-gia" name="gia" required>
              </div>

              <div class="form-group">
                <label for="edit-hinh">Hình ảnh</label>
                <img id="edit-hinh-preview" src="" width="200" class="mb-4">
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
        <form id="deleteForm" method="POST" action="deleteSanPham.php">
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
                document.getElementById("edit-hinh-preview").src = "images/" + this.dataset.hinh;

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
</script>



<?php require('includes/footer.php'); ?>
