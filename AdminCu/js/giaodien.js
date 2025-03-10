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
})

const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11'],
    datasets: [{
      label: 'Tương đương đơn vị 1.000.000đ',
      data: [10, 25, 24, 19, 26, 30],
      backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)'
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 5,
          color: '#666'
        },
        grid: {
          color: 'rgba(200, 200, 200, 0.3)'
        }
      },
      x: {
        ticks: {
          color: '#333'
        }
      }
    }
  }
});

// Define the data first
var DoughnutChart = {
    datasets: [{
        data: [43,30,27], // Values of the segments
        backgroundColor: ["#fcc79e", "#ffddfb", "#fff5bc"] // Colors of the segments
    }],
    labels: ["Đồng hồ nam", "Đồng hồ treo tường", "Đồng hồ nữ"] // Optional labels for each segment
};

// Create the chart with the updated context name
var chartContext = document.getElementById("canvas").getContext("2d"); // Rename ctx to chartContext
var myDoughnutChart = new Chart(chartContext, {
    type: 'doughnut',
    data: DoughnutChart,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                enabled: true
            }
        }
    }
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

