// Lấy các phần tử từ DOM
const submitButton = document.querySelector('.submit-button');
const usernameInput = document.getElementById('tendangnhap');
const passwordInput = document.getElementById('matkhau');

// Tạo tài khoản hợp lệ
const validUsername = "abcd1234";
const validPassword = "abcd1234";

// Thêm sự kiện khi nhấn nút đăng nhập
submitButton.addEventListener('click', function(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của nút submit

    // Lấy giá trị từ ô nhập liệu
    const enteredUsername = usernameInput.value;
    const enteredPassword = passwordInput.value;

    // Kiểm tra thông tin đăng nhập
    if (enteredUsername === validUsername && enteredPassword === validPassword) {
        // Nếu thông tin đúng, chuyển hướng đến trang giaodien.html
        window.location.href = 'giaodien.html';
    } else {
        // Nếu thông tin sai, thông báo lỗi
        alert('Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại.');
    }
});
