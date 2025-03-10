// Hàm mở popup sửa sản phẩm
function moPopupSuaSanPham(sanPham) {
    document.getElementById('productId').value = sanPham.ma; // Mã sản phẩm
    document.getElementById('productName').value = sanPham.ten; // Tên sản phẩm
    document.getElementById('productPrice').value = sanPham.gia; // Giá sản phẩm
    document.getElementById('productStatus').value = sanPham.tinhTrang; // Tình trạng

    const currentImage = document.getElementById('currentImage');
    currentImage.src = sanPham.hinhAnh; // Hình ảnh
    currentImage.style.display = 'block'; // Hiển thị hình ảnh hiện tại

    // Hiển thị modal
    document.getElementById('editProductModal').style.display = 'flex';
}

// Gán sự kiện cho các nút sửa
document.querySelectorAll('.sua').forEach(button => {
    button.onclick = function(event) {
        event.stopPropagation(); // Ngăn chặn sự kiện lan ra ngoài
        const row = button.closest('tr');
        const sanPham = {
            ma: row.cells[0].innerText, // Mã sản phẩm (cột đầu tiên mới)
            ten: row.cells[1].innerText, // Tên sản phẩm
            hinhAnh: row.cells[2].querySelector('img').src, // Hình ảnh
            tinhTrang: row.cells[3].innerText, // Tình trạng
            gia: row.cells[4].innerText // Giá sản phẩm
        };
        moPopupSuaSanPham(sanPham);
    };
});

document.getElementById('removeImage').addEventListener('click', function () {
    // Lấy phần tử ảnh trong popup
    const currentImage = document.getElementById('currentImage');
    const productImageInput = document.getElementById('productImage');
    
    // Lấy mã sản phẩm từ trường ẩn trong popup
    const productId = document.getElementById('productId').value;

    // Xóa hình ảnh hiển thị trong popup và ẩn nó đi
    currentImage.src = ''; // Xóa nguồn hình ảnh
    currentImage.style.display = 'none'; // Ẩn hình ảnh hiện tại

    // Reset input file
    productImageInput.value = ''; // Đặt lại giá trị input file

    // Cập nhật bảng: Tìm ô ảnh tương ứng với sản phẩm
    const rows = document.querySelectorAll('#productTable tbody tr');
    rows.forEach(row => {
        const idCell = row.cells[0];
        if (idCell && idCell.textContent === productId) {
            // Lấy phần tử ảnh trong bảng
            const imageCell = row.cells[2];
            const image = imageCell.querySelector('img');

            // Nếu ảnh tồn tại, xóa nó
            if (image) {
                image.src = ''; // Xóa nguồn hình ảnh trong bảng
                image.style.display = 'none'; // Ẩn ảnh trong bảng
            }
        }
    });
});

// Đóng popup khi nhấn vào nút đóng
document.querySelector('.close').onclick = function() {
    document.getElementById('editProductModal').style.display = 'none';
};

// Đóng popup khi nhấn ra ngoài nội dung popup
window.onclick = function(event) {
    const modal = document.getElementById('editProductModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

// Xử lý lưu thông tin sản phẩm khi gửi form
document.getElementById('editProductForm').onsubmit = function(event) {
    event.preventDefault(); // Ngăn chặn gửi form

    // Lưu thông tin sửa đổi ở đây
    const maSanPham = document.getElementById('productId').value;
    const tenSanPham = document.getElementById('productName').value;
    const giaSanPham = document.getElementById('productPrice').value;
    const tinhTrangSanPham = document.getElementById('productStatus').value;

    // Cập nhật sản phẩm trong bảng nếu cần
    // Code cập nhật vào bảng ở đây

    // Đóng popup
    document.getElementById('editProductModal').style.display = 'none';
};

function confirmDelete(event) {
    event.preventDefault();
    
    const result = confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?");
    if (result) {
        const row = event.target.closest("tr");
        if (row) {
            row.remove(); // Xóa hàng

            // Hiển thị thông báo xóa thành công
            const successPopup = document.getElementById('deleteSuccessPopup');
            successPopup.style.display = 'block'; // Hiển thị popup

            // Ẩn thông báo sau 3 giây
            setTimeout(function() {
                successPopup.style.display = 'none';
            }, 3000);
        }
    }
}

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

document.addEventListener("DOMContentLoaded", function () {
    const filterButton = document.querySelector(".nutloc button"); // Nút "Lọc"
    const filterSelect = document.querySelector("#mucloc"); // Menu thả xuống
    const productTable = document.querySelector("#productTable tbody"); // Bảng sản phẩm

    filterButton.addEventListener("click", function () {
        const selectedCategory = filterSelect.value.trim(); // Lấy giá trị lọc
        const rows = productTable.querySelectorAll("tr"); // Các hàng trong bảng

        rows.forEach(row => {
            const categoryCell = row.cells[5]; // Cột "Danh mục" (cột thứ 6)
            if (!categoryCell) return; // Bỏ qua nếu không tìm thấy cột
            const categoryText = categoryCell.textContent.trim(); // Lấy nội dung cột "Danh mục"

            // Hiển thị hoặc ẩn hàng dựa trên giá trị được chọn
            if (selectedCategory === "" || categoryText === selectedCategory) {
                row.style.display = ""; // Hiển thị
            } else {
                row.style.display = "none"; // Ẩn
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll("#productTable tbody tr");

    rows.forEach(row => {
        const statusCell = row.querySelector(".tinhtrang");
        if (!statusCell) return;

        const statusText = statusCell.textContent.trim().toLowerCase();

        // Gán class dựa trên trạng thái
        if (statusText === "còn hàng") {
            statusCell.classList.add("status-available");
        } else if (statusText === "hết hàng") {
            statusCell.classList.add("status-out");
        } else {
            statusCell.classList.add("status-unknown");
        }
    });
});

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

