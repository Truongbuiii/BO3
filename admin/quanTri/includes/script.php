 <!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>



<script>
    function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function () {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = reader.result;
        imagePreview.style.display = "block"; // Hiển thị ảnh khi đã chọn file
    };

    if (input.files.length > 0) {
        reader.readAsDataURL(input.files[0]);
        document.getElementById("file-name").textContent = input.files[0].name;
    } else {
        document.getElementById("file-name").textContent = "Chưa có tệp nào";
    }
}

</script>



<!-- JavaScript kiểm tra form -->
<script>
    function validateForm() {
    const tenNguoiDung = document.getElementById("tenDangNhap").value.trim();
    const hoVaTen = document.getElementById("hoVaTen").value.trim();
    const tinhThanhPho = document.getElementById("tinh").value.trim();
    const quanHuyen = document.getElementById("huyen").value.trim();
    const phuongXa = document.getElementById("xa").value.trim();
    const diaChiCuThe  = document.getElementById("diaChi").value.trim();
    const soDienThoai = document.getElementById("soDienThoai").value.trim();
    const email = document.getElementById("email").value.trim();
    const matKhau = document.getElementById("password1").value;
    const nhapLaiMatKhau = document.getElementById("password2").value;
    const vaiTro = document.getElementById("vaiTro").value.trim();

    // Biểu thức chính quy kiểm tra số điện thoại (bắt đầu bằng 0, độ dài 10-11 số)
    const phoneRegex = /^0[0-9]{9,10}$/;
    // Biểu thức chính quy kiểm tra email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Mảng chứa các trường bị thiếu
    let missingFields = [];

    if (!tenNguoiDung) missingFields.push("Tên đăng nhập");
    if (!hoVaTen) missingFields.push("Họ và tên");
    if (!tinhThanhPho) missingFields.push("Tỉnh/Thành phố");
    if (!quanHuyen) missingFields.push("Quận/Huyện");
    if (!phuongXa) missingFields.push("Phường/Xã");
    if (!diaChiCuThe) missingFields.push("Địa chỉ cụ thể");
    if (!soDienThoai) missingFields.push("Số điện thoại");
    if (!email) missingFields.push("Email");
    if (!matKhau) missingFields.push("Mật khẩu");
    if (!nhapLaiMatKhau) missingFields.push("Nhập lại mật khẩu");
    if (!vaiTro) missingFields.push("Vai trò");

    if (missingFields.length > 0) {
        alert("Vui lòng nhập đầy đủ thông tin: " + missingFields.join(", ") + "!");
        return false;
    }

    // Kiểm tra định dạng số điện thoại
    if (!phoneRegex.test(soDienThoai)) {
        alert("Số điện thoại không hợp lệ! Số điện thoại phải bắt đầu bằng số 0 và có độ dài 10-11 chữ số.");
        return false;
    }

    // Kiểm tra định dạng email
    if (!emailRegex.test(email)) {
        alert("Địa chỉ email không hợp lệ!");
        return false;
    }

    // Kiểm tra khớp mật khẩu
    if (matKhau !== nhapLaiMatKhau) {
        alert("Mật khẩu và nhập lại mật khẩu không khớp!");
        return false;
    }

    alert("Đăng ký thành công!");
    return true;
}
</script>

<script>
   const addressData = {
    "TP Hồ Chí Minh": {
   "Quận 1": ["Phường Cầu Kho","Phường Bến Nghé", "Phường Bến Thành", "Phường Cầu Ông Lãnh", "Phường Cô Giang", "Phường Nguyễn Thái Bình"],
  "Quận 2":["Phường An Phú","Phường Tân Bình","Phường Tân Phú"],
    "Quận 3": ["Phường Võ Thị Sáu", "Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7","Phường 14"],
  "Quận 4":["Phường 10","Phường 11","Phường 12","Phường 13"],
    "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 8"],
  "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10"],
  "Quận 7": ["Phường Tân Thuận Tây","Phường Tân Phong", "Phường Tân Hưng", "Phường Bình Thuận", "Phường Phú Mỹ", "Phường Tân Kiểng", "Phường Tân Quy", "Phường Tân Phú"],
"Quận 8":["Phường 11","Phường 15"],
"Quận 9":["Phường Hiệp Phú","Phường Hiệp Bình Chánh","Phường Long Trường"],
  "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8","Phường 9"],
  "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 16", "Phường 7"],
  "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 25", "Phường 6", "Phường 7", "Phường 8"],
  "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7"],
  "Thành phố Thủ Đức": ["Phường Bình Chiểu", "Phường Bình Thọ", "Phường Hiệp Bình Chánh", "Phường Hiệp Phú", "Phường Linh Trung", "Phường Linh Đông"],
  "Quận Bình Tân": ["Phường Bình Hưng Hòa", "Phường Bình Trị Đông", "Phường Tân Tạo", "Phường An Lạc", "Phường Bình Hưng Hòa A", "Phường Bình Hưng Hòa B"],
  "Huyện Nhà Bè": ["Xã Phước Kiển", "Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức"],
  "Quận Phú Nhuận":["Phường 9"]
}
};

// Load danh sách tỉnh/thành phố khi trang tải
window.onload = function () {
    const tinhSelect = document.getElementById("tinh");
    Object.keys(addressData).forEach(tinh => {
        let option = document.createElement("option");
        option.value = tinh;
        option.text = tinh;
        tinhSelect.appendChild(option);
    });
};

// Load Quận/Huyện theo tỉnh/thành phố
function loadHuyen() {
    const tinhSelect = document.getElementById("tinh");
    const huyenSelect = document.getElementById("huyen");
    const xaSelect = document.getElementById("xa");

    huyenSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
    xaSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
    xaSelect.disabled = true;

    if (tinhSelect.value) {
        Object.keys(addressData[tinhSelect.value]).forEach(huyen => {
            let option = document.createElement("option");
            option.value = huyen;
            option.text = huyen;
            huyenSelect.appendChild(option);
        });
        huyenSelect.disabled = false;
    } else {
        huyenSelect.disabled = true;
    }
}

// Load Phường/Xã theo Quận/Huyện
function loadXa() {
    const tinhSelect = document.getElementById("tinh").value;
    const huyenSelect = document.getElementById("huyen").value;
    const xaSelect = document.getElementById("xa");

    xaSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

    if (huyenSelect) {
        addressData[tinhSelect][huyenSelect].forEach(xa => {
            let option = document.createElement("option");
            option.value = xa;
            option.text = xa;
            xaSelect.appendChild(option);
        });
        xaSelect.disabled = false;
    } else {
        xaSelect.disabled = true;
    }
}

</script>