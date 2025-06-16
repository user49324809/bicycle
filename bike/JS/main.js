//подключение всплывающего меню авторизации
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}
function subscribe(event) {
    event.preventDefault();
    var email = document.getElementById('emailInput').value;
    console.log("Подписка на email: " + email);
    alert("Вы успешно подписаны на новости!");
}

//плавная прокрутка
