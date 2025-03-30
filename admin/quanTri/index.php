<?php 
 require('includes/header.php');
  ?>

  <?php 
require("./db/connect.php");

$sql = "SELECT SanPham.MaSanPham , SanPham.TenSanPham, LoaiSanPham.TenLoai,SanPham.HuongVi,SanPham.TinhTrang
       FROM SanPham
       Join LoaiSanPham ON SanPham.MaLoai = LoaiSanPham.MaLoai
";

$result = mysqli_query($conn,$sql);
if(!$result){
    die("Lỗi truy vấn: " . mysqli_error($conn)); // Kiểm tra lỗi truy vấn
}
  ?>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Lượng đặt mua hàng</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">40 đơn hàng</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Doanh thu tháng</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">20.000.000đ</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                       

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Lượng tin nhắn </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                      <div class="col-xl-8 col-lg-7">
    <div class="card shadow-lg mb-4 border-left-primary">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Biểu đồ thể hiện doanh số</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </a>
               
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thống kê % số lượng loại sản phẩm được bán</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        </a>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Kem que
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Kem ốc quế
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Kem ly
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg-12 mb-4"> <!-- Thay col-lg-6 thành col-lg-12 để chứa đủ 2 card -->

        <div class="row"> <!-- Tạo một hàng mới để đặt 2 card cạnh nhau -->
                    <div class="col-md-6"> <!-- Mỗi card chiếm 6 cột -->
                        <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
            <a href="danhsachsanpham.php" class="btn btn-primary btn-sm">Xem tất cả</a>
        </div>

                        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại kem</th>
                            <th>Hương vị</th>
                            <th>Tình trạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['MaSanPham']}</td>
                                        <td>{$row['TenSanPham']}</td>
                                        <td>{$row['TenLoai']}</td>
                                        <td>{$row['HuongVi']}</td>
                                        <td>" . ($row['TinhTrang'] ? 
                                            "<span class='badge badge-success'>Mở</span>" : 
                                            "<span class='badge badge-danger'>Khóa</span>") . "
                                        </td>
                                    </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

                        </div>
                    </div>

                   <div class="col-md-6"> <!-- Mỗi card chiếm 6 cột -->
                        <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
            <a href="danhsachdonhang.php" class="btn btn-primary btn-sm">Xem tất cả</a>
        </div>

                        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại kem</th>
                            <th>Hương vị</th>
                            <th>Tình trạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['MaSanPham']}</td>
                                        <td>{$row['TenSanPham']}</td>
                                        <td>{$row['TenLoai']}</td>
                                        <td>{$row['HuongVi']}</td>
                                        <td>" . ($row['TinhTrang'] ? 
                                            "<span class='badge badge-success'>Mở</span>" : 
                                            "<span class='badge badge-danger'>Khóa</span>") . "
                                        </td>
                                    </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
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

