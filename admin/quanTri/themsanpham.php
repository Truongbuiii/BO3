<?php
require 'includes/header.php';
require './db/connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenSanPham = $_POST['tenSanPham'];
    $maLoai = $_POST['MaLoai'];  // Lấy MaLoai thay vì loaiKem
    $huongVi = $_POST['huongVi'];
    $tinhTrang = $_POST['tinhTrang'];
    $dienGiai = $_POST['dienGiai'];
    $gia = $_POST['DonGia'] ?? null;
    $hinhAnhPath = ''; // Chỉ lưu tên file hình ảnh

    if (empty($gia)) {
        echo "<div class='alert alert-danger'>Bạn chưa nhập đơn giá.</div>";
    } else {
        // chạy lệnh insert
    }

if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['HinhAnh']['tmp_name'];
    $fileName = $_FILES['HinhAnh']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileExtension, $allowedExtensions)) {
        $uploadDir = '../../images/'; // Đường dẫn tương đối đến thư mục ảnh
        $newFileName = time() . '-' . uniqid() . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        // Kiểm tra xem thư mục có tồn tại không, nếu không thì tạo thư mục
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Tạo thư mục nếu chưa có
        }

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $hinhAnhPath = $newFileName;  // Lưu tên file vào database, không lưu đường dẫn đầy đủ
        } else {
            echo "<div class='alert alert-danger'>Lỗi khi tải ảnh lên.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Chỉ chấp nhận định dạng JPG, PNG, GIF.</div>";
    }
}


    // ✅ Thêm vào DB nếu có ảnh
    if ($hinhAnhPath !== '') {
        // Tạo mã sản phẩm tự động kiểu SP001, SP002,...
        $result = $conn->query("SELECT MaSanPham FROM SanPham ORDER BY MaSanPham DESC LIMIT 1");

        if ($result && $row = $result->fetch_assoc()) {
            $lastMa = $row['MaSanPham']; // VD: SP007
            $number = intval(substr($lastMa, 2)) + 1;
            $newMaSanPham = 'SP' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } else {
            $newMaSanPham = 'SP001';
        }

      $stmt = $conn->prepare("INSERT INTO SanPham (MaSanPham, tenSanPham, MaLoai, huongVi, dienGiai, tinhTrang, DonGia, hinhAnh) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssiis", $newMaSanPham, $tenSanPham, $maLoai, $huongVi, $dienGiai, $tinhTrang, $gia, $hinhAnhPath);

        if ($stmt->execute()) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showModal('Thêm sản phẩm thành công!', 'success');
                });
            </script>";
        } else {
            $error = addslashes($stmt->error);
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showModal('Lỗi: $error', 'error');
                });
            </script>";
        }
    }
}
?>

<!-- Mã HTML form ở đây -->


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
                        <label class="LoaiKem">Loại kem</label>
                        <select class="form-control" id="loaiKem" name="MaLoai" required>
                        <option value="" disabled selected>Chọn loại kem</option>
                        <option value="L02">Kem que</option> <!-- Giả sử '1' là MaLoai của Kem que -->
                        <option value="L01">Kem ốc quế</option> <!-- Giả sử '2' là MaLoai của Kem ốc quế -->
                        <option value="L03">Kem ly</option> <!-- Giả sử '3' là MaLoai của Kem ly -->
                    </select>

                    </div>

                    <div class="form-group">
                        <label for="huongVi">Hương vị</label>
                        <input type="text" class="form-control" id="huongVi" name="huongVi" placeholder="Hãy nhập hương vị" required>
                    </div>

                    <div class="form-group">
                        <label for="dienGiai">Diễn giải</label>
                        <input type="text" class="form-control" id="dienGiai" name="dienGiai" placeholder="Hãy nhập diễn giải" required>

                    </div>

                    <div class="form-group">
                        <label for="tinhTrang">Tình trạng</label>
                        <select class="form-control" id="tinhTrang" name="tinhTrang" required>
                            <option value="" disabled selected>Chọn tình trạng</option>
                            <option value="1">Mở</option>
                            <option value="2">Khóa</option>
                        </select>
                    </div>
                    <div class="form-group">
    <label for="price">Đơn giá</label>
    <input type="number" class="form-control" id="price" name="DonGia" placeholder="Hãy nhập giá sản phẩm" required min="0">
</div>

                  
                <div class="form-group">
                    <label for="pic">Hình ảnh :</label>

                    <!-- Nút tùy biến -->
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('pic').click();">
                        Chọn ảnh <i class="fa-solid fa-cloud-arrow-up"></i>
                    </button>

                    <!-- Input ẩn -->
                    <input type="file" class="form-control" id="pic" name="HinhAnh"
                        accept="*" onchange="previewImage(event)" style="display: none;">

                    <span id="file-name">Chưa có tệp nào</span>

                    <!-- Hiển thị ảnh -->
                    <img id="imagePreview" src="" alt="Hình ảnh sẽ hiển thị tại đây"
                        style="display: none; width: 150px; margin-top: 10px; border: 1px solid #ccc; padding: 5px;">
                </div>



<script>
    function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();

    if (input.files && input.files[0]) {
        var file = input.files[0];

        // Hiển thị tên file
        document.getElementById("file-name").innerText = file.name;

        reader.onload = function () {
            var imgElement = document.getElementById("imagePreview");
            imgElement.src = reader.result;
            imgElement.style.display = "block";
        };

        reader.readAsDataURL(file);
    } else {
        // Không có file nào được chọn
        document.getElementById("file-name").innerText = "Chưa có tệp nào";
        document.getElementById("imagePreview").style.display = "none";
    }
}

</script>

                    <button class="btn btn-primary mt-3" type="submit">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>


<script>// kiểm tra đã nhập đủ chưa
document.querySelector('form.user').addEventListener('submit', function(event) {
    let isValid = true;
    let errorMessages = [];

    const tenSanPham = document.getElementById('name').value.trim();
    const maLoai = document.getElementById('loaiKem').value;
    const huongVi = document.getElementById('huongVi').value.trim();
    const dienGiai = document.getElementById('dienGiai').value.trim();
    const tinhTrang = document.getElementById('tinhTrang').value;
    const donGia = document.getElementById('price').value.trim();
    const hinhAnh = document.getElementById('pic').files.length;

    if (!tenSanPham) {
        isValid = false;
        errorMessages.push("Vui lòng nhập tên sản phẩm.");
    }
    if (!maLoai) {
        isValid = false;
        errorMessages.push("Vui lòng chọn loại kem.");
    }
    if (!huongVi) {
        isValid = false;
        errorMessages.push("Vui lòng nhập hương vị.");
    }
    if (!dienGiai) {
        isValid = false;
        errorMessages.push("Vui lòng nhập diễn giải.");
    }
    if (!tinhTrang) {
        isValid = false;
        errorMessages.push("Vui lòng chọn tình trạng.");
    }
    if (!donGia || isNaN(donGia)) {
        isValid = false;
        errorMessages.push("Vui lòng nhập đơn giá hợp lệ.");
    }
    if (hinhAnh === 0) {
        isValid = false;
        errorMessages.push("Vui lòng chọn hình ảnh.");
    }

    if (!isValid) {
        event.preventDefault();
        alert(errorMessages.join("\n"));
    }
});


  function showModal(message, type = 'success') {
    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
    const modalBody = document.querySelector('#messageModal .modal-body');
    const modalTitle = document.getElementById('messageModalLabel');

    modalTitle.innerText = type === 'success' ? 'Thành công' : 'Lỗi';
    modalBody.innerHTML = message;
    modal.show();
  }
</script>





<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <!-- Nội dung sẽ được cập nhật bằng JS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>



    <?php
    require 'includes/footer.php';
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
