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


document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const content = document.querySelector(".content");
    const toggleButton = document.createElement("button");

    // Tạo nút toggle
    toggleButton.className = "sidebar-toggle";
    toggleButton.textContent = "☰"; // Icon hoặc text
    document.body.appendChild(toggleButton);

    // Xử lý sự kiện click vào nút toggle
    toggleButton.addEventListener("click", function () {
        sidebar.classList.toggle("hidden");
        content.classList.toggle("full-width");

        // Điều chỉnh vị trí của nút
        if (sidebar.classList.contains("hidden")) {
            toggleButton.style.left = "20px"; // Vị trí khi sidebar ẩn
        } else {
            toggleButton.style.left = "220px"; // Vị trí khi sidebar hiện
        }
    });
});


  
  