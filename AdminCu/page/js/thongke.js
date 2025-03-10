const toggleSubmenuLinks = document.querySelectorAll('.toggle-submenu');

toggleSubmenuLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        const submenu = this.nextElementSibling;
        const icon = this.querySelector('i');

        if (submenu.style.display === 'block') {
            submenu.style.display = 'none';
            icon.classList.remove('fa-caret-down');
            icon.classList.add('fa-caret-right');
        } else {
            submenu.style.display = 'block';
            icon.classList.remove('fa-caret-right');
            icon.classList.add('fa-caret-down');
        }
    });
});

// Dữ liệu giả định về sản phẩm và khách hàng
const products = [
{ code: 'SPNAM1', name: 'Đồng hồ nam Classic', price: '1,500,000 VND', category: 'Đồng hồ nam', date: '2024-11-21', sold: 8,invoice: 'SPNAM1' },
{ code: 'SPNAM2', name: 'Đồng hồ nam Sporty', price: '3,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-19', sold: 5,invoice: 'SPNAM2' },
{ code: 'SPNAM3', name: 'Đồng hồ nam Elegance', price: '2,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-22', sold: 6,invoice: 'SPNAM3' },
{ code: 'SPNAM4', name: 'Đồng hồ nam Luxury', price: '2,200,000 VND', category: 'Đồng hồ nam', date: '2024-11-05', sold: 1,invoice: 'SPNAM4' },
{ code: 'SPNAM5', name: 'Đồng hồ nam Premium', price: '3,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-09', sold: 2,invoice: 'SPNAM5' },
{ code: 'SPNAM6', name: 'Đồng hồ nam Sport', price: '3,200,000 VND', category: 'Đồng hồ nam', date: '2024-11-11', sold: 0,invoice: 'SPNAM6' },
{ code: 'SPNAM7', name: 'Đồng hồ nam Retro', price: '1,600,000 VND', category: 'Đồng hồ nam', date: '2024-11-13', sold: 9,invoice: 'SPNAM7' },
{ code: 'SPNAM8', name: 'Đồng hồ nam Active', price: '2,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-25', sold: 10,invoice: 'SPNAM8' },
{ code: 'SPNAM9', name: 'Đồng hồ nam Supreme', price: '1,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-17', sold: 3,invoice: 'SPNAM9' },
{ code: 'SPNAM10', name: 'Đồng hồ nam Explorer', price: '4,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-05', sold: 3,invoice: 'SPNAM10' },
{ code: 'SPNAM11', name: 'Đồng hồ nam Signature', price: '5,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-01', sold: 1,invoice: 'SPNAM11' },
{ code: 'SPNAM12', name: 'Đồng hồ nam Iconic', price: '5,100,000 VND', category: 'Đồng hồ nam', date: '2024-11-23', sold: 6,invoice: 'SPNAM11' },
{ code: 'SPNU1', name: 'Đồng hồ nữ classic', price: '1,500,000 VND', category: 'Đồng hồ nữ', date: '2024-11-25', sold: 8,invoice: 'SPNU1' }, 
{ code: 'SPNU2', name: 'Đồng hồ nữ Sporty', price: '3,100,000 VND', category: 'Đồng hồ nữ', date: '2024-11-25', sold: 6,invoice: 'SPNU2' },
{ code: 'SPNU3', name: 'Đồng hồ nữ Elegance', price: '3,100,000 VND', category: 'Đồng hồ nữ', date: '2024-11-30', sold: 0,invoice: 'SPNU3' },
{ code: 'SPNU4', name: 'Đồng hồ nữ Fashion', price: '2,100,000 VND', category: 'Đồng hồ nữ', date: '2024-11-15', sold: 7,invoice: 'SPNU4' },
{ code: 'SPNU5', name: 'Đồng hồ nữ Glamour', price: '2,200,000 VND', category: 'Đồng hồ nữ', date: '2024-11-12', sold: 5,invoice: 'SPNU5' } ,
{ code: 'SPNU6', name: 'Đồng hồ nữ Luxury', price: '7,100,000 VND', category: 'Đồng hồ nữ', date: '2024-11-04', sold: 2,invoice: 'SPNU6' },
{ code: 'SPTT1', name: 'Đồng hồ treo tường Royal', price: '1,550,000 VND', category: 'Đồng hồ treo tường', date: '2024-11-16', sold: 5,invoice: 'SPTT1' },
{ code: 'SPTT2', name: 'Đồng hồ treo tường Imperil', price: '2,200,000 VND', category: 'Đồng hồ treo tường', date: '2024-11-20', sold:4,invoice: 'SPTT2' },
{ code: 'SPTT3', name: 'Đồng hồ treo tường Modern', price: '3,100,000 VND', category: 'Đồng hồ treo tường', date: '2024-11-25', sold: 3,invoice: 'SPTT3' },
{ code: 'SPTT4', name: 'Đồng hồ treo tường Vintage', price: '3,900,000 VND', category: 'Đồng hồ treo tường', date: '2024-11-14', sold: 5,invoice: 'SPTT4' },
{ code: 'SPTT5', name: 'Đồng hồ treo tường Elegant', price: '4,000,000 VND', category: 'Đồng hồ treo tường', date: '2024-11-18', sold: 1,invoice: 'SPTT5' },
{ code: 'SPTT6', name: 'Đồng hồ treo tường Fresh', price: '3,150,000 VND', category: 'Đồng hồ treo tường', date: '2024-11-25', sold: 6,invoice: 'SPTT6'},
{ code: 'SPBT1', name: 'Đồng hồ báo thức Twin Bell', price: '1,800,000 VND', category: 'Đồng hồ báo thức', date: '2024-11-20', sold: 2,invoice: 'SPBT1' },
{ code: 'SPBT2', name: 'Đồng hồ báo thức Silent', price: '6,100,000 VND', category: 'Đồng hồ báo thức', date: '2024-11-30', sold: 0,invoice: 'SPBT2' },
{ code: 'SPBT3', name: 'Đồng hồ báo thức Glow', price: '3,500,000 VND', category: 'Đồng hồ báo thức', date: '2024-11-04', sold: 3,invoice: 'SPBT3'},
{ code: 'SPBT4', name: 'Đồng hồ báo thức Digital', price: '2,400,000 VND', category: 'Đồng hồ báo thức', date: '2024-11-21', sold: 6,invoice: 'SPBT4' },
{ code: 'SPBT5', name: 'Đồng hồ báo thức Sunrise', price: '4,100,000 VND', category: 'Đồng hồ báo thức', date: '2024-11-25', sold: 1,invoice: 'SPBT5'},
{ code: 'SPBT6', name: 'Đồng hồ báo thức Light', price: '3,100,000 VND', category: 'Đồng hồ báo thức', date: '2024-11-25', sold: 5,invoice: 'SPBT6' }
];


// Dữ liệu mẫu khách hàng
const customers =[
    { id: 'KH001', name: 'Nguyễn Văn Linh', revenue: '8,250,000 VND', purchaseDate: '2024-11-10', invoice: 'HD001'},
    { id: 'KH002', name: 'Trần Thị Hoa', revenue: '15,500,000 VND', purchaseDate: '2024-11-12', invoice: 'HD002' },
    { id: 'KH003', name: 'Lê Văn Tấn', revenue: '23,950,000 VND', purchaseDate: '2024-11-05', invoice: 'HD003' },
    { id: 'KH004', name: 'Nguyễn Thị Lan', revenue: '9,150,000 VND', purchaseDate: '2024-11-17', invoice: 'HD004' },
    { id: 'KH005', name: 'Phan Minh Trí', revenue: '12,600,000 VND', purchaseDate: '2024-11-15', invoice: 'HD005' },
    { id: 'KH006', name: 'Võ Thị Mai', revenue: '10,800,000 VND', purchaseDate: '2024-11-20', invoice: 'HD006' },
    { id: 'KH007', name: 'Bùi Văn Giang', revenue: '15,500,000 VND', purchaseDate: '2024-11-30', invoice: 'HD007' },
    { id: 'KH008', name: 'Hoàng Thị Hương', revenue: '10,500,000 VND', purchaseDate: '2024-11-25', invoice: 'HD008' }
];



document.getElementById('statistics-filter').addEventListener('submit', function(e) {
e.preventDefault();

const startDateInput = document.getElementById('start-date').value;
const endDateInput = document.getElementById('end-date').value;

// Kiểm tra nếu người dùng đã nhập ngày bắt đầu và ngày kết thúc
if (!startDateInput || !endDateInput) {
   alert('Vui lòng chọn ngày bắt đầu và ngày kết thúc!');
   return;
}


const startDate = new Date(startDateInput);
const endDate = new Date(endDateInput);
// Tính doanh thu tự động từ giá và số lượng bán
products.forEach(product => {
// Chuyển giá trị price từ chuỗi sang số, loại bỏ 'VND' và dấu phẩy
const price = parseInt(product.price.replace(' VND', '').replace(/,/g, ''), 10);
const sold = product.sold || 0; // Đảm bảo rằng số lượng bán không phải là null hoặc undefined

const revenue = price * sold;

// Định dạng doanh thu với dấu phân cách hàng nghìn, không có phần thập phân
product.revenue = revenue.toLocaleString('en-US') + ' VND'; // Dùng en-US để đảm bảo định dạng hàng nghìn đúng
});

console.log(products);

// Tính doanh thu tự động từ giá và số lượng bán
let totalRevenue = 0; // Biến để lưu tổng doanh thu

products.forEach(product => {
// Chuyển giá trị price từ chuỗi sang số, loại bỏ 'VND' và dấu phẩy
const price = parseInt(product.price.replace(' VND', '').replace(/,/g, ''), 10);
const sold = product.sold || 0; // Đảm bảo rằng số lượng bán không phải là null hoặc undefined

const revenue = price * sold;
// Định dạng doanh thu với dấu phân cách hàng nghìn, không có phần thập phân
product.revenue = revenue.toLocaleString('en-US') + ' VND'; // Dùng en-US để đảm bảo định dạng hàng nghìn đúng
totalRevenue += revenue; // Cộng doanh thu của từng sản phẩm vào tổng doanh thu
});

// Hiển thị tổng doanh thu
document.getElementById('total-revenue').textContent = `Tổng doanh thu của tháng: ${totalRevenue.toLocaleString('en-US')} VND`;

console.log(products);



// Lọc sản phẩm bán chạy và bán ế
const filteredProducts = products.filter(product => {
   const productDate = new Date(product.date);
   return productDate >= startDate && productDate <= endDate;
});

const bestSellers = filteredProducts.filter(product => product.sold >= 5).sort((a, b) => b.sold - a.sold);
const unsoldProducts = filteredProducts.filter(product => product.sold < 5);

// Hiển thị sản phẩm bán chạy
const bestSellersList = document.getElementById('best-sellers-list');
bestSellersList.innerHTML = ''; // Clear previous entries
bestSellers.forEach(product => {
   const row = document.createElement('tr');
   row.innerHTML = `
       <td>${product.code}</td>
       <td>${product.name}</td>
       <td>${product.category}</td>
       <td>${product.price}</td>
       <td>${product.sold}</td>
       <td>${product.revenue}</td>  <!-- Đưa giá trị doanh thu ở đây -->
        <td><button><a href="invoices/${product.invoice}.html" style="text-decoration: none; color: inherit;">Xem hóa đơn</a></button></td>
   `;
   bestSellersList.appendChild(row);
});

// Hiển thị sản phẩm bán ế
const unsoldProductsList = document.getElementById('unsold-products-list');
unsoldProductsList.innerHTML = ''; // Clear previous entries
unsoldProducts.forEach(product => {
   const row = document.createElement('tr');
   row.innerHTML = `
       <td>${product.code}</td>
       <td>${product.name}</td>
       <td>${product.category}</td>
       <td>${product.price}</td>
       <td>${product.sold}</td>
       <td>${product.revenue}</td>  <!-- Đưa giá trị doanh thu ở đây -->
        <td><button><a href="invoices/${product.invoice}.html" style="text-decoration: none; color: inherit;">Xem hóa đơn</a></button></td>
   `;
   unsoldProductsList.appendChild(row);
});

// Thống kê khách hàng
const filteredCustomers = customers.filter(customer => {
   const customerDate = new Date(customer.purchaseDate);
   return customerDate >= startDate && customerDate <= endDate;
});

const customerStatsList = document.getElementById('customer-statistics-list');
customerStatsList.innerHTML = ''; // Clear previous entries
filteredCustomers.forEach(customer => {
   const row = document.createElement('tr');
   row.innerHTML = `
       <td>${customer.id}</td>
       <td>${customer.name}</td>
       <td>${customer.revenue}</td>  <!-- Đưa giá trị doanh thu ở đây -->
       <td>${customer.purchaseDate}</td>
       <td><button><a href="invoices/${customer.invoice}.html" style="text-decoration: none; color: inherit;">Xem hóa đơn</a></button></td>
   `;
   customerStatsList.appendChild(row);
});

// Sắp xếp khách hàng theo doanh thu giảm dần
const top5HighestRevenueCustomers = filteredCustomers
   .sort((a, b) => parseInt(b.revenue.replace(' VND', '').replace(',', '')) - parseInt(a.revenue.replace(' VND', '').replace(',', '')))
   .slice(0, 5); // Lấy 5 khách hàng có doanh thu cao nhất

// Xóa các mục đã có trong danh sách
const highestRevenueCustomerList = document.getElementById('highest-revenue-customer-list');
highestRevenueCustomerList.innerHTML = ''; 

// Thêm các khách hàng có doanh thu cao nhất vào bảng
top5HighestRevenueCustomers.forEach(customer => {
   const row = document.createElement('tr');
   row.innerHTML = `
       <td>${customer.id}</td>
       <td>${customer.name}</td>
       <td>${customer.revenue}</td>  <!-- Đưa giá trị doanh thu ở đây -->
       <td>${customer.purchaseDate}</td>
       <td><button><a href="invoices/${customer.invoice}.html" style="text-decoration: none; color: inherit;">Xem hóa đơn</a></button></td>
   `;
   highestRevenueCustomerList.appendChild(row);
});
});

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    const toggleButton = document.createElement('button');
    toggleButton.className = 'sidebar-toggle';
    toggleButton.innerHTML = '<i class="fas fa-bars"></i>';

    // Append toggle button to the body
    document.body.appendChild(toggleButton);

    // Toggle the sidebar and adjust the button's position
    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('hidden'); // Toggle sidebar visibility

        // Adjust button position with smooth transition
        if (sidebar.classList.contains('hidden')) {
            toggleButton.style.left = '30px'; // Move to the left
        } else {
            toggleButton.style.left = '215px'; // Move back to the original position
        }
    });
});

