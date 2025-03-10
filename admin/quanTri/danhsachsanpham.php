<?php require('includes/header.php'); ?>
<div>
  <h3>Trang danh sách sản phẩm</h3>

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
                          <th>Loại máy</th>
                          <th>Tình trạng</th>
                          <th>Giá</th>
                          <th>Hình ảnh</th>
                          <th>Danh mục</th>
                          <th>Số lượng</th>
                          <th>Đường kính</th>
                          <th>Chức năng</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Mã sản phẩm</th>
                          <th>Tên sản phẩm</th>
                          <th>Loại máy</th>
                          <th>Tình trạng</th>
                          <th>Giá</th>
                          <th>Hình ảnh</th>
                          <th>Danh mục</th>
                          <th>Số lượng</th>
                          <th>Đường kính</th>
                          <th>Chức năng</th>
                      </tr>
                  </tfoot>
                  <tbody>

                  <?php
                  require('../db/conn.php'); // Kết nối CSDL

$sql_str = "SELECT SanPham.*, danhmuc.ten_danhmuc 
            FROM SanPham 
            JOIN danhmuc ON SanPham.danhmuc_id = danhmuc.id
            ORDER BY SanPham.id";
                  $result = mysqli_query($conn, $sql_str);
                  while ($row = mysqli_fetch_assoc($result)) { 
                  ?>
                      <tr>
                          <td><?php echo $row['id']; ?></td>
                          <td><?php echo $row['ten_sanpham']; ?></td>
                          <td><?php echo $row['loaimay']; ?></td>
                          <td><?php echo $row['tinhtrang']; ?></td>
                          <td><?php echo number_format($row['gia'], 0, ',', '.') . " VND"; ?></td>
<td><img src="<?php echo $row['hinhanh']; ?>" width="80"></td>
                          <td><?php echo $row['ten_danhmuc']; ?></td>
                          <td><?php echo $row['soluong'] ?></td>
                          <td><?php echo $row['duongkinh'] ? $row['duongkinh'] . ' mm' : 'Không có'; ?></td>
                          <td>
                              <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                              <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                          </td>
                      </tr>
                  <?php      
                  }
                  ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<?php require('includes/footer.php'); ?>
