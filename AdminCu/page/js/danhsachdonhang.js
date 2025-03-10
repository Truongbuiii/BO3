document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    const toggleButton = document.createElement('button');
    toggleButton.className = 'sidebar-toggle';
    toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
    document.body.appendChild(toggleButton);

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        if (sidebar.classList.contains('hidden')) {
            content.style.marginLeft = '0';
            toggleButton.style.left = '30px';
        } else {
            content.style.marginLeft = '200px';
            toggleButton.style.left = '215px';
        }
    });
});


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
// Lấy tất cả các nút "Xem chi tiết"
document.querySelectorAll('.view-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn hành vi mặc định của nút

        // Lấy dữ liệu từ dòng hiện tại trong bảng
        const row = this.closest('tr');
        const orderData = {
            id: row.cells[0].innerText,
            customerName: row.cells[1].innerText,
            orderDate: row.cells[2].innerText,
            orderTime: row.cells[3].innerText,
            orderItem: row.cells[4].innerText,
            orderTotal: row.cells[5].innerText,
            orderLocate: row.cells[6].innerText,
            orderStatus: row.cells[7].innerText,
        };

        // Lưu thông tin vào sessionStorage
        sessionStorage.setItem('orderDetail', JSON.stringify(orderData));

        // Chuyển hướng tới trang chi tiết
        window.location.href = 'donhangchitiet.html'; // Đảm bảo đường dẫn là chính xác
    });
});
// Hiển thị popup khi nhấn vào nút "Sửa"
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
        const row = button.closest('tr'); // Lấy dòng gần nhất chứa nút "Sửa"

        // Lưu dòng hiện tại vào biến toàn cục để sử dụng sau khi chỉnh sửa
        window.currentRow = row;
        
        // Lấy thông tin từ các ô trong dòng
        const orderId = row.cells[0].textContent.trim(); // ID
        const customerName = row.cells[1].textContent.trim(); // Khách hàng
        const orderDate = row.cells[2].textContent.trim(); // Ngày
        const orderTime = row.cells[3].textContent.trim(); // Giờ
        const orderTotal = row.cells[5].textContent.replace('₫', '').trim(); // Tổng (loại bỏ ký hiệu tiền tệ)
        const orderAddress = row.cells[6].textContent.trim(); // Địa chỉ
        const orderStatus = row.cells[7].textContent.trim(); // Tình trạng

        // Hiển thị popup
        document.getElementById('suapopup').style.display = 'flex';

        // Đặt giá trị cho các trường chỉnh sửa
        document.getElementById('edit-order-id').value = orderId;
        document.getElementById('edit-customer-name').value = customerName;
        document.getElementById('edit-order-date').value = orderDate;
        document.getElementById('edit-order-time').value = orderTime;
        document.getElementById('edit-order-total').value = orderTotal;
        document.getElementById('edit-order-address').value = orderAddress;

        // Cập nhật tình trạng đơn hàng
        const statusSelect = document.getElementById('suatrinhtrang');
        for (let i = 0; i < statusSelect.options.length; i++) {
            if (statusSelect.options[i].text === orderStatus) {
                statusSelect.selectedIndex = i; // Chọn tình trạng tương ứng
                break;
            }
        }
    });
});
// Đóng popup khi nhấn vào nút "Đóng"
document.querySelector('.tatpopupsua').addEventListener('click', () => {
    document.getElementById('suapopup').style.display = 'none';
});

// Lưu thay đổi
document.getElementById('save-edit').addEventListener('click', () => {
    if (window.currentRow) {
        // Cập nhật các ô trong bảng với thông tin từ popup
        window.currentRow.cells[1].textContent = document.getElementById('edit-customer-name').value;
        window.currentRow.cells[2].textContent = document.getElementById('edit-order-date').value;
        window.currentRow.cells[3].textContent = document.getElementById('edit-order-time').value;
        window.currentRow.cells[5].textContent = document.getElementById('edit-order-total').value + '₫';
        window.currentRow.cells[6].textContent = document.getElementById('edit-order-address').value;

        // Cập nhật tình trạng đơn hàng và màu sắc tương ứng
        const selectedStatus = document.getElementById('suatrinhtrang').options[document.getElementById('suatrinhtrang').selectedIndex].text;
        const statusCell = window.currentRow.cells[7];
        statusCell.textContent = selectedStatus;

        // Xóa các lớp màu cũ và thêm lớp mới dựa trên tình trạng
        statusCell.classList.remove('dangxuly', 'daxuly', 'dagiao', 'dahuy');
        switch (selectedStatus) {
            case 'Đang xử lý':
                statusCell.classList.add('dangxuly');
                break;
            case 'Đã xử lý':
                statusCell.classList.add('daxuly');
                break;
            case 'Đã giao thành công':
                statusCell.classList.add('dagiao');
                break;
            case 'Đã hủy':
                statusCell.classList.add('dahuy');
                break;
        }

        // Hiển thị thông báo lưu thành công và đóng popup
        alert('Đã lưu thay đổi!');
        document.getElementById('suapopup').style.display = 'none';

        // Xóa biến currentRow sau khi hoàn tất
        window.currentRow = null;
    }
}); 

// Xóa hàng khi nhấn nút "Xóa"
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', () => {
        // Hiển thị hộp thoại xác nhận
        const confirmation = confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');

        if (confirmation) {
            const row = button.closest('tr'); // Lấy dòng gần nhất chứa nút xóa
            row.remove(); // Xóa dòng khỏi bảng
            const successPopup = document.getElementById('deleteSuccessPopup');
            successPopup.style.display = 'block'; // Hiển thị popup

            // Ẩn thông báo sau 3 giây
            setTimeout(function() {
                successPopup.style.display = 'none';
            }, 3000);
        }
    });
});

document.getElementById('loc').addEventListener('click', function () {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const selectedTinhTrang = document.getElementById('tinhtrang').value;

    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        const dateCell = row.querySelector('td:nth-child(3)').textContent.trim(); // Ngày từ cột thứ 3
        const tinhTrangCell = row.querySelector('td:nth-child(8) span').classList.contains(selectedTinhTrang); // Lớp của tình trạng từ cột thứ 8

        let showRow = true;

        // Lọc theo ngày
        if (startDate && endDate) {
            const rowDate = new Date(dateCell);
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (rowDate < start || rowDate > end) {
                showRow = false;
            }
        }

        // Lọc theo tình trạng
        if (selectedTinhTrang && !tinhTrangCell) {
            showRow = false;
        }

        // Hiển thị hoặc ẩn dòng dựa trên điều kiện
        row.style.display = showRow ? '' : 'none';
    });
});

document.getElementById('locquan').addEventListener('click', function () {
    const selectedDistrict = document.getElementById('quan').value; // Lấy quận đã chọn từ <select>
    const rows = document.querySelectorAll('table tbody tr'); // Lấy tất cả các hàng trong bảng

    rows.forEach(row => {
        const address = row.cells[6].innerText.trim(); // Lấy địa chỉ từ cột "Địa chỉ" (cột thứ 6)
        
        // Nếu không chọn quận nào, hiển thị tất cả các hàng
        if (selectedDistrict === "") {
            row.style.display = ""; // Hiển thị tất cả
        } else {
            // Kiểm tra xem quận đã chọn có phải là một số hay không
            const isNumber = !isNaN(selectedDistrict); // Kiểm tra nếu là số
            let regex;

            if (isNumber) {
                // Kiểm tra quận theo số (ví dụ: Quận 1, Quận 12)
                regex = new RegExp(`Quận\\s?${selectedDistrict}(?!\\d)`, 'i'); // Tìm "Quận <số>" chính xác
            } else {
                // Kiểm tra quận theo tên (ví dụ: Quận Bình Thạnh)
                regex = new RegExp(`Quận\\s?${selectedDistrict}`, 'i'); // Tìm tên quận có chứa chữ
            }

            if (regex.test(address)) {
                row.style.display = ""; // Hiển thị hàng nếu địa chỉ chứa quận đã chọn (theo số hoặc theo tên)
            } else {
                row.style.display = "none"; // Ẩn hàng nếu không khớp với quận đã chọn
            }
        }
    });
});


document.getElementById('loctinhtrang').addEventListener('click', function () {
    // Lấy giá trị của tùy chọn trong select
    const selectedStatus = document.getElementById('tinhtrang').value;

    // Lấy tất cả các dòng của bảng
    const rows = document.querySelectorAll('table tbody tr');

    // Lọc các dòng dựa trên tình trạng
    rows.forEach(row => {
        // Lấy nội dung của cột tình trạng (td với class "tinhtrang")
        const statusCell = row.querySelector('td:nth-child(8) span');

        if (statusCell) {
            // Kiểm tra nếu giá trị tình trạng khớp với lựa chọn, hiển thị dòng đó
            if (statusCell.classList.contains(selectedStatus)) {
                row.style.display = ''; // Hiển thị dòng
            } else {
                row.style.display = 'none'; // Ẩn dòng
            }
        }
    });
});