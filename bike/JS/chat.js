document.addEventListener("DOMContentLoaded", () => {
    const openChatBtn = document.getElementById("openChatBtn");
    const closeChatBtn = document.getElementById("closeChatBtn");
    const chatPanel = document.getElementById("chatPanel");

    openChatBtn?.addEventListener("click", () => {
        chatPanel.classList.remove("d-none");
    });

    closeChatBtn?.addEventListener("click", () => {
        chatPanel.classList.add("d-none");
    });
});

document.querySelectorAll('.reply-btn').forEach(button => {
    button.addEventListener('click', () => {
        const username = button.getAttribute('data-username');
        const messageField = document.querySelector('textarea[name="message"]');
        messageField.value = `@${username}, ` + messageField.value;
        messageField.focus();
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Находим все кнопки для редактирования
    const editBtns = document.querySelectorAll('.edit-btn');
    
    // Проверяем, что кнопки найдены
    console.log('Кнопки редактирования:', editBtns);
    
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Печатаем данные атрибутов кнопки в консоль
            const messageId = this.getAttribute('data-id');
            const messageText = this.getAttribute('data-message');
            
            console.log('Редактирование сообщения с ID:', messageId, 'Сообщение:', messageText);
            
            // Пример: выводим в поле для сообщения
            document.querySelector('[name="message"]').value = messageText;
            document.querySelector('[name="message_id"]').value = messageId; // Скрытое поле для ID
        });
    });
});




