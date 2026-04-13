const currentUrl = window.location.pathname;

document.querySelectorAll('.site-header__nav a').forEach(link => {
    const linkPath = new URL(link.href).pathname;

    if (linkPath === currentUrl || 
        (linkPath !== '/' && currentUrl.startsWith(linkPath))) {
        link.classList.add('active');
    }
});