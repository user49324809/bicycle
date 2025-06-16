document.addEventListener('DOMContentLoaded', function () {
    const submitReviewBtn = document.getElementById('submit_review');
    const reviewForm = document.getElementById('chatForm');
    const stars = document.querySelectorAll('#starRating .star'); 
    let selectedRating = 0; 
    // Обработка кликов по звездам
    stars.forEach(star => {
        star.addEventListener('click', function () {
            selectedRating = parseInt(this.getAttribute('data-value'));  
            stars.forEach(s => s.textContent = '☆');
            for (let i = 0; i < selectedRating; i++) {
                stars[i].textContent = '★';
            }
        });
    });
    // Обработчик нажатия кнопки отправки отзыва
    submitReviewBtn.addEventListener('click', function (e) {
        e.preventDefault(); 
        const reviewerName = document.getElementById('username').value.trim();
        const reviewText = document.getElementById('review_text').value.trim();
        const reviewDate = document.getElementById('review_date').value;
        const hasColorIssue = document.getElementById('color_issue').checked;

        // Проверка на заполненность всех обязательных полей
        if (reviewerName && reviewText && selectedRating > 0 && reviewDate) {
            const formData = new FormData();
            formData.append('username', reviewerName);
            formData.append('review_text', reviewText);
            formData.append('rating', selectedRating);
            formData.append('review_date', reviewDate);
            formData.append('color_issue', hasColorIssue ? '1' : '0');
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                } else {
                    alert(data.message); 
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert("Ошибка при отправке отзыва");
            });
        } else {
            alert("Пожалуйста, заполните все поля.");
        }
    });
});








