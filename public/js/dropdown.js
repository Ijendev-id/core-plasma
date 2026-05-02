(function () {
    const btn = document.getElementById('admin-avatar-btn');
    const dropdown = document.getElementById('admin-dropdown');

    if (!btn || !dropdown) return;

    let isOpen = false;

    function openMenu() {
        isOpen = true;
        dropdown.style.display = 'block';
        requestAnimationFrame(function () {
            dropdown.style.opacity = '1';
            dropdown.style.transform = 'scale(1)';
        });
        btn.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        isOpen = false;
        dropdown.style.opacity = '0';
        dropdown.style.transform = 'scale(0.95)';
        setTimeout(function () {
            if (!isOpen) dropdown.style.display = 'none';
        }, 150);
        btn.setAttribute('aria-expanded', 'false');
    }

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        isOpen ? closeMenu() : openMenu();
    });

    document.addEventListener('click', function (e) {
        if (isOpen && !dropdown.contains(e.target)) closeMenu();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isOpen) closeMenu();
    });
})();
