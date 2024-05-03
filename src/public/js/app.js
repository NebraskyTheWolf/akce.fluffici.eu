function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = (sidebar.style.display === 'none' || sidebar.style.display === '') ? 'block' : 'none';
}
