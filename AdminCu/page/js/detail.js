
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

// Lấy thông tin từ sessionStorage
const orderData = JSON.parse(sessionStorage.getItem('orderDetail'));

if (orderData) {
    // Hiển thị thông tin lên trang
    document.getElementById('order-id').innerText = orderData.id;
    document.getElementById('customer-name').innerText = orderData.customerName;
    document.getElementById('order-date').innerText = orderData.orderDate;
    document.getElementById('order-time').innerText = orderData.orderTime;
    document.getElementById('order-address').innerText = orderData.orderLocate;
    document.getElementById('order-total').innerText = orderData.orderTotal;
    document.getElementById('order-status').innerText = orderData.orderStatus;
} else {
    alert('Không có thông tin đơn hàng.');
    window.location.href = '/page/danhsachdonhang.html'; // Quay lại nếu không có dữ liệu
}

// Get the stored order status from localStorage
const orderStatus = localStorage.getItem('orderStatus');

// Set the order status in the details section
const orderStatusElement = document.getElementById('order-status');
if (orderStatus) {
    // Set the text of the status
    orderStatusElement.innerText = getStatusText(orderStatus);
    // Set the data-status attribute to trigger the color change
    orderStatusElement.setAttribute('data-status', orderStatus);
    // Apply the corresponding styles based on the status
    applyStatusColor(orderStatus);
}

// Function to map the status value to its display text
function getStatusText(status) {
    switch (status) {
        case 'pending':
            return 'Chưa xử lý';
        case 'confirmed':
            return 'Đã xác nhận';
        case 'delivered':
            return 'Đã giao thành công';
        case 'canceled':
            return 'Đã huỷ';
        default:
            return 'Không xác định';
    }
}

// Function to apply the color based on the status
function applyStatusColor(status) {
    const orderStatusElement = document.getElementById('order-status');
    
    switch (status) {
        case 'pending':
            orderStatusElement.style.backgroundColor = '#fff3cd'; // Yellowish for pending
            orderStatusElement.style.color = '#856404'; // Dark yellow text
            break;
        case 'confirmed':
            orderStatusElement.style.backgroundColor = '#d4edda'; // Greenish for confirmed
            orderStatusElement.style.color = '#155724'; // Dark green text
            break;
        case 'delivered':
            orderStatusElement.style.backgroundColor = '#c3e6cb'; // Light green for delivered
            orderStatusElement.style.color = '#155724'; // Dark green text
            break;
        case 'canceled':
            orderStatusElement.style.backgroundColor = '#df0013'; // Bright red for canceled
            orderStatusElement.style.color = '#ffffff'; // White text
            break;
        default:
            orderStatusElement.style.backgroundColor = '#f8d7da'; // Light red for undefined status
            orderStatusElement.style.color = '#721c24'; // Dark red text for undefined status
    }
}

// Example: Adding event listener to order rows in the order list
const orderRows = document.querySelectorAll('.order-row'); // Assuming each row has a class 'order-row'
orderRows.forEach(row => {
    row.addEventListener('click', function () {
        // Get the status from the data-status attribute
        const status = row.querySelector('#order-status').getAttribute('data-status');
        
        // Store status in localStorage
        localStorage.setItem('orderStatus', status);

        // Redirect to the order detail page
        window.location.href = '/page/donhangchitiet.html'; // Adjust the URL to match your setup
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

