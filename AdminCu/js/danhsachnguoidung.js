
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
// Khóa/Mở khóa người dùng
document.querySelectorAll('.khoa').forEach(button => {
    button.addEventListener('click', function() {
        const userRow = this.closest('tr'); // Lấy hàng người dùng
        const icon = this.querySelector('i'); // Lấy biểu tượng khóa/mở khóa

        // Hỏi xác nhận trước khi khóa người dùng
        if (icon.classList.contains('fa-lock')) {
            if (confirm('Bạn có chắc chắn muốn khóa người dùng này không?')) {
                icon.classList.replace('fa-lock', 'fa-unlock');
                this.title = 'Mở khóa người dùng';
                userRow.style.backgroundColor = '#FAFAD2'; // Màu nền cho người dùng bị khóa

                // Vô hiệu hóa nút sửa và xóa
                userRow.querySelector('.sua').disabled = true;
                userRow.querySelector('.xoa').disabled = true;
            }
        } else {
            icon.classList.replace('fa-unlock', 'fa-lock');
            this.title = 'Khóa người dùng';
            userRow.style.backgroundColor = ''; // Đặt lại màu nền cho người dùng không bị khóa

            // Bật lại nút sửa và xóa
            userRow.querySelector('.sua').disabled = false;
            userRow.querySelector('.xoa').disabled = false;
        }
    });
});

// Sự kiện click cho nút xóa
document.querySelectorAll('.xoa').forEach(button => {
    button.addEventListener('click', function() {
        const userRow = this.closest('tr'); // Lấy hàng người dùng

        // Kiểm tra xem người dùng có bị khóa hay không
        if (userRow.querySelector('.khoa i').classList.contains('fa-unlock')) {
            alert('Người dùng này đã bị khóa và không thể xóa!');
            return; // Ngăn không cho xóa
        }

        if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
            userRow.remove(); // Xóa hàng người dùng
            
            // Hiển thị thông báo xóa thành công
            const successPopup = document.getElementById('deleteSuccessPopup');
            successPopup.style.display = 'block'; // Hiển thị popup

            // Ẩn thông báo sau 3 giây
            setTimeout(function() {
                successPopup.style.display = 'none';
            }, 3000);
        }
    });
});

// Sự kiện click cho nút sửa
document.querySelectorAll('.sua').forEach(button => {
    button.addEventListener('click', function() {
        const userRow = this.closest('tr'); // Lấy hàng người dùng

        // Kiểm tra xem người dùng có bị khóa hay không
        if (userRow.querySelector('.khoa i').classList.contains('fa-unlock')) {
            alert('Người dùng này đã bị khóa và không thể sửa!');
            return; // Ngăn không cho sửa
        }

       
    });
});
// Sửa thông tin người dùng
document.querySelectorAll('.sua').forEach(button => {
    button.addEventListener('click', function() {
        const row = this.closest('tr');
        const cells = row.querySelectorAll('td');
        
        // Dữ liệu hiện tại của người dùng
        const name = cells[1].innerText;
        const fullname = cells[2].innerText;
        const address = cells[3].innerText;
        const email = cells[4].innerText;
        const role = cells[5].innerText;

        // Hiển thị form sửa và cập nhật thông tin
        const editForm = document.createElement('div');
        editForm.classList.add('popup-overlay');
        editForm.innerHTML = `
            <div class="popup-content">
                <h3>Chỉnh sửa thông tin người dùng</h3>
                <label>Tên người dùng: <input type="text" id="edit-name" value="${name}"></label><br>
                <label>Họ và tên: <input type="text" id="edit-fullname" value="${fullname}"></label><br>
                <label>Địa chỉ: <input type="text" id="edit-address" value="${address}"></label><br>
                <label>Email: <input type="text" id="edit-email" value="${email}"></label><br>
                <label>Vai trò: <input type="text" id="edit-role" value="${role}"></label><br>
                <button id="save-edit">Lưu</button>
                <button id="cancel-edit">Hủy</button>
            </div>
        `;
        document.body.appendChild(editForm);

        // Lưu thay đổi
        document.getElementById('save-edit').addEventListener('click', function() {
            cells[1].innerText = document.getElementById('edit-name').value;
            cells[2].innerText = document.getElementById('edit-fullname').value;
            cells[3].innerText = document.getElementById('edit-address').value;
            cells[4].innerText = document.getElementById('edit-email').value;
            cells[5].innerText = document.getElementById('edit-role').value;
            document.body.removeChild(editForm);
        });

        // Hủy chỉnh sửa
        document.getElementById('cancel-edit').addEventListener('click', function() {
            document.body.removeChild(editForm);
        });
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
            content.style.marginLeft = '0px';
            toggleButton.style.left = '30px'; // Move to the left
        } else {
            content.style.marginLeft = '120px';
            toggleButton.style.left = '215px'; // Move to the sidebar edge
        }
    });
});