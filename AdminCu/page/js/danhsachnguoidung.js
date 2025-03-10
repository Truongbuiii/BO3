
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
// Hàm chuyển đổi ngày từ định dạng dd/mm/yyyy sang yyyy-mm-dd
function convertToDateInputFormat(date) {
    const [day, month, year] = date.split('/');
    return `${year}-${month}-${day}`;
}

// Hàm chuyển đổi ngày từ định dạng yyyy-mm-dd sang dd/mm/yyyy
function convertToDisplayFormat(dateStr) {
    const date = new Date(dateStr);
    const day = String(date.getDate()).padStart(2, '0');  // Đảm bảo có 2 chữ số cho ngày
    const month = String(date.getMonth() + 1).padStart(2, '0');  // Tháng bắt đầu từ 0, cộng thêm 1
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

// Sửa thông tin người dùng
document.querySelectorAll('.sua').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        const cells = row.querySelectorAll('td');

        // Dữ liệu hiện tại của người dùng
        const name = cells[1].innerText;
        const birthday = cells[2].innerText;  // Lấy ngày sinh từ cột
        const gender = cells[3].innerText;    // Lấy giới tính
        const address = cells[4].innerText;
        const email = cells[5].innerText;
        const phone = cells[6].innerText;

        // Chuyển đổi ngày sinh sang định dạng yyyy-mm-dd để hiển thị trong input[type="date"]
        const formattedBirthday = convertToDateInputFormat(birthday);

        // Hiển thị form sửa và cập nhật thông tin
        const editForm = document.createElement('div');
        editForm.classList.add('popup-overlay');
        editForm.innerHTML = `
            <div class="popup-content">
                <h3>Chỉnh sửa thông tin người dùng</h3>
                <label>Tên người dùng: <input type="text" id="edit-name" value="${name}"></label><br>
                <label>Ngày sinh: <input type="date" id="edit-birthday" value="${formattedBirthday}"></label><br>
                <label>Giới tính:
                    <select id="edit-gender" style="width: 100px; height: 35px; border: 2px solid #ccc; border-radius: 5px; padding: 5px;">
                        <option value="Nam" ${gender === 'Nam' ? 'selected' : ''}>Nam</option>
                        <option value="Nữ" ${gender === 'Nữ' ? 'selected' : ''}>Nữ</option>
                    </select>
                </label><br>
                <label>Địa chỉ: <input type="text" id="edit-address" value="${address}"></label><br>
                <label>Email: <input type="text" id="edit-email" value="${email}"></label><br>
                <label>Số điện thoại: <input type="text" id="edit-phone" value="${phone}"></label><br>
                <button id="save-edit">Lưu</button>
                <button id="cancel-edit">Hủy</button>
            </div>
        `;
        document.body.appendChild(editForm);

        // Lưu thay đổi
        document.getElementById('save-edit').addEventListener('click', function () {
            cells[1].innerText = document.getElementById('edit-name').value;
            cells[2].innerText = convertToDisplayFormat(document.getElementById('edit-birthday').value);  // Cập nhật ngày sinh ở định dạng dd/mm/yyyy
            cells[3].innerText = document.getElementById('edit-gender').value;
            cells[4].innerText = document.getElementById('edit-address').value;
            cells[5].innerText = document.getElementById('edit-email').value;
            cells[6].innerText = document.getElementById('edit-phone').value;
            document.body.removeChild(editForm);
        });

        // Hủy chỉnh sửa
        document.getElementById('cancel-edit').addEventListener('click', function () {
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