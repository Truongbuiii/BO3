// Lấy tất cả các mục có class "toggle-submenu"
const toggleSubmenuLinks = document.querySelectorAll('.toggle-submenu');

toggleSubmenuLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của link
        const submenu = this.nextElementSibling;
        const icon = this.querySelector('i');

        // Kiểm tra nếu sub-menu đã mở thì ẩn nó đi, nếu chưa mở thì hiển thị
        if (submenu.style.display === 'block') {
            submenu.style.display = 'none';
            icon.classList.remove('fa-caret-down');
            icon.classList.add('fa-caret-right'); // Đổi về tam giác phải khi đóng
        } else {
            submenu.style.display = 'block';
            icon.classList.remove('fa-caret-right');
            icon.classList.add('fa-caret-down'); // Đổi thành tam giác xuống khi mở
        }
    });
});

// Lấy các phần tử từ DOM
const saveButton = document.querySelector('.luu');

// Hàm hiển thị popup thông báo
function showPopup(message) {
    const popup = document.createElement('div');
    popup.classList.add('popup');
    popup.innerHTML = `<p>${message}</p><button class="close-btn">Đóng</button>`;

    // Thêm popup vào body
    document.body.appendChild(popup);

    // Đóng popup khi nhấn vào nút "Đóng"
    const closeButton = popup.querySelector('.close-btn');
    closeButton.addEventListener('click', () => {
        document.body.removeChild(popup);
    });
}

// Kiểm tra dữ liệu khi nhấn nút Lưu
saveButton.addEventListener('click', function(event) {
    event.preventDefault();

    // Kiểm tra nếu các ô dữ liệu đã được nhập đầy đủ
    const productCode = document.getElementById('masanpham').value;
    const productName = document.getElementById('tensanpham').value;
    const productPrice = document.getElementById('giaban').value;
    const productStatus = document.getElementById('tinhtrang').value;
    const productCategory = document.getElementById('danhmuc').value;

    if (productCode && productName && productPrice && productStatus && productCategory) {
        // Hiển thị popup nếu các trường đã được nhập
        showPopup("Sản phẩm đã được thêm thành công!");

        // Reset lại form sau khi thêm sản phẩm thành công
        document.getElementById('masanpham').value = '';
        document.getElementById('tensanpham').value = '';
        document.getElementById('giaban').value = '';
        document.getElementById('tinhtrang').value = '';
        document.getElementById('danhmuc').value = '';
        document.getElementById('fileNameDisplay').textContent = ''; // Reset tên ảnh nếu có
    } else {
        // Thông báo nếu các trường chưa được nhập đầy đủ
        showPopup("Vui lòng nhập đầy đủ thông tin sản phẩm.");
    }
});

// Hàm upload ảnh
function uploadImage() {
    // Kích hoạt sự kiện click cho input file ẩn
    document.getElementById("uploadFile").click();
}

// Hàm hiển thị tên ảnh đã chọn
function displayImageName() {
    // Lấy tên của file đã chọn
    const fileInput = document.getElementById("uploadFile");
    const fileNameDisplay = document.getElementById("fileNameDisplay");
    if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = `Bạn đã chọn ảnh : ${fileInput.files[0].name}`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    const toggleButton = document.createElement('button');
    toggleButton.className = 'sidebar-toggle';
    toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
    document.body.appendChild(toggleButton);

    // Event listener for toggle button
    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('hidden'); // Toggle sidebar visibility

        // Adjust position of toggle button with smooth animation
        if (sidebar.classList.contains('hidden')) {
            content.style.marginLeft = '0';
            toggleButton.style.left = '30px'; // Move to the left
        } else {
            content.style.marginLeft = '200px';
            toggleButton.style.left = '215px'; // Move to the sidebar edge
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Lấy các thành phần cần thiết
    const filterButton = document.querySelector(".nutloc");
    const filterSelect = document.querySelector(".phanloai");
    const productTable = document.querySelector("#productTable tbody");

    // Sự kiện khi nhấn nút lọc
    filterButton.addEventListener("click", function () {
        const filterValue = filterSelect.value.trim(); // Lấy giá trị được chọn từ dropdown
        const rows = productTable.querySelectorAll("tr"); // Lấy tất cả các hàng trong bảng

        rows.forEach(row => {
            const statusCell = row.querySelector(".tinhtrang"); // Lấy ô "Tình trạng" của hàng
            if (statusCell) {
                const statusText = statusCell.textContent.trim(); // Lấy nội dung trong ô "Tình trạng"
                if (filterValue === "" || statusText === filterValue) {
                    row.style.display = ""; // Hiển thị hàng nếu khớp
                } else {
                    row.style.display = "none"; // Ẩn hàng nếu không khớp
                }
            }
        });
    });
});
