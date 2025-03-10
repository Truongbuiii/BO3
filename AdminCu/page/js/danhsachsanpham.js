// Hàm mở popup sửa sản phẩm
function moPopupSuaSanPham(sanPham) {
    // Cập nhật các thông tin khác vào form trong popup
    document.getElementById('productId').value = sanPham.ma; // Mã sản phẩm
    document.getElementById('productName').value = sanPham.ten; // Tên sản phẩm
    document.getElementById('productPrice').value = sanPham.gia; // Giá sản phẩm

    // Cập nhật tình trạng cho input trong popup
    document.getElementById('productStatus').value = sanPham.tinhTrang; // Trạng thái sản phẩm

    // Cập nhật hình ảnh
    const currentImage = document.getElementById('currentImage');
    currentImage.src = sanPham.hinhAnh; // Hình ảnh
    currentImage.style.display = 'block'; // Hiển thị hình ảnh hiện tại

    // Hiển thị modal
    document.getElementById('editProductModal').style.display = 'flex';
}

// Lắng nghe sự kiện click trên các nút sửa
document.querySelectorAll('.sua').forEach(button => {
    button.onclick = function (event) {
        event.stopPropagation(); // Ngăn chặn sự kiện lan ra ngoài
        const row = button.closest('tr');
        const sanPham = {
            ma: row.cells[0].innerText, // Mã sản phẩm (cột đầu tiên)
            ten: row.cells[1].innerText, // Tên sản phẩm (cột thứ 2)
            hinhAnh: row.cells[2].querySelector('img').src, // Hình ảnh (cột thứ 3)
            tinhTrang: row.cells[3].innerText, // Tình trạng (cột thứ 4)
            gia: row.cells[4].innerText // Giá sản phẩm (cột thứ 5)
        };
        moPopupSuaSanPham(sanPham); // Mở popup và truyền thông tin sản phẩm
    };
});

// Xử lý khi chọn ảnh mới
document.getElementById('productImage').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const currentImage = document.getElementById('currentImage');

    if (file) {
        // Tạo một đối tượng FileReader để đọc ảnh
        const reader = new FileReader();
        
        reader.onload = function (e) {
            currentImage.src = e.target.result; // Đặt src của hình ảnh bằng kết quả đọc được
            currentImage.style.display = 'block'; // Hiển thị hình ảnh mới
        };

        reader.readAsDataURL(file); // Đọc ảnh dưới dạng URL
    }
});

// Hàm xử lý xóa hình ảnh
document.getElementById('removeImage').addEventListener('click', function () {
    // Lấy phần tử ảnh trong popup
    const currentImage = document.getElementById('currentImage');
    const productImageInput = document.getElementById('productImage');
    
    // Lấy mã sản phẩm từ trường ẩn trong popup
    const productId = document.getElementById('productId').value;

    // Kiểm tra nếu có hình ảnh hiện tại
    if (currentImage.src !== '') {
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
    }

    // Kiểm tra nếu không có hình ảnh thì ẩn nút "Bỏ hình"
    if (currentImage.src === '') {
        document.getElementById('removeImage').style.display = 'none'; // Ẩn nút "Bỏ hình"
    }
});

// Kiểm tra khi popup mở để ẩn nút "Bỏ hình" nếu không có hình ảnh
function checkImageVisibility() {
    const currentImage = document.getElementById('currentImage');
    const removeImageButton = document.getElementById('removeImage');

    if (currentImage.src === '' || currentImage.style.display === 'none') {
        removeImageButton.style.display = 'none'; // Ẩn nút nếu không có hình ảnh
    } else {
        removeImageButton.style.display = 'block'; // Hiển thị nút nếu có hình ảnh
    }
}

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


// Xử lý sự kiện xác nhận xóa và hiển thị popup thông báo thành công
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