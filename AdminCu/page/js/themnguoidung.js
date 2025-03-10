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

