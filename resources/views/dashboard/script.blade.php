<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarBtn = document.querySelector('.sidebarBtn');

    sidebarBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

    // Live Clock
    const clock = document.getElementById('clock');
    function updateClock() {
        const now = new Date();
        clock.textContent = now.toLocaleTimeString();
    }
    setInterval(updateClock, 1000);
    updateClock();
});
</script>
