document.addEventListener('DOMContentLoaded', () => {
    const darkMode = window.localStorage.getItem('themeDark') === 'on';
    if (darkMode) {
        document.documentElement.classList.add('dark-mode');
    }
});
