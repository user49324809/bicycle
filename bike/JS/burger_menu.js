function toggleSidebar() {
    const menu = document.querySelector('.sidebar'); // Предположим, у вас есть боковое меню
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block'; // Показать боковое меню
    } else {
        menu.style.display = 'none'; // Скрыть боковое меню
    }
}