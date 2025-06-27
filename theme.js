function setTheme(mode) {
    document.body.classList.remove('light-mode', 'dark-mode');
    document.body.classList.add(mode + '-mode');
    document.cookie = "theme=" + mode + ";path=/;max-age=31536000";
    // Update all theme toggle buttons on the page
    document.querySelectorAll('.theme-toggle').forEach(btn => {
        btn.textContent = mode === 'dark' ? '☀️ Light Mode' : '🌙 Dark Mode';
    });
}
function getTheme() {
    let match = document.cookie.match(/(?:^|; )theme=([^;]+)/);
    return match ? match[1] : null;
}
document.addEventListener('DOMContentLoaded', function() {
    let theme = getTheme() || 'light';
    setTheme(theme);

    document.querySelectorAll('.theme-toggle').forEach(btn => {
        btn.textContent = theme === 'dark' ? '☀️ Light Mode' : '🌙 Dark Mode';
        btn.onclick = function() {
            let newTheme = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
            setTheme(newTheme);
        };
    });
});