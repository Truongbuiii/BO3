<?php
require 'includes/header.php';
require './db/connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenSanPham = $_POST['tenSanPham'];
    $maLoai = $_POST['MaLoai'];  // Lấy MaLoai thay vì loaiKem
    $huongVi = $_POST['huongVi'];
    $tinhTrang = $_POST['tinhTrang'];
$gia = $_POST['DonGia'] ?? null;
    $hinhAnhPath = ''; // Đường dẫn ảnh để lưu vào DB



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
            $uploadDir = 'uploads/';
            $newFileName = time() . '-' . uniqid() . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $hinhAnhPath = $destPath; // Lưu đường dẫn để thêm vào DB
            } else {
                echo "<div class='alert alert-danger'>Lỗi khi tải ảnh lên.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Chỉ chấp nhận định dạng JPG, PNG, GIF.</div>";
        }
    }

    // ✅ Thêm vào DB nếu có ảnh
    if ($hinhAnhPath !== '') {
       
$stmt = $conn->prepare("INSERT INTO SanPham (tenSanPham, MaLoai, huongVi, tinhTrang, DonGia, hinhAnh) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiis", $tenSanPham, $maLoai, $huongVi, $tinhTrang, $gia, $hinhAnhPath);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Thêm sản phẩm thành công!</div>";
        } else {
            echo "<div class='alert alert-danger'>Lỗi: " . $stmt->error . "</div>";
        }
        $stmt->close();
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
                            <option value="1">Sẵn hàng</option>
                            <option value="2">Không sẵn hàng</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Đơn giá</label>
<input type="text" class="form-control" id="price" name="DonGia" placeholder="Hãy nhập giá sản phẩm" required>
                    </div>

                  
                <div class="form-group">
                    <label for="pic">Hình ảnh :</label>

                    <!-- Nút tùy biến -->
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('pic').click();">
                        Chọn ảnh <i class="fa-solid fa-cloud-arrow-up"></i>
                    </button>

                    <!-- Input ẩn -->
                    <input type="file" class="form-control" id="pic" name="HinhAnh"
                        accept="image/*" onchange="previewImage(event)" style="display: none;">

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
<script>
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
</script>

    <?php
    require 'includes/footer.php';
    ?>
