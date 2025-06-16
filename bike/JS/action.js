document.addEventListener('DOMContentLoaded', function () {
    const countdownEl = document.getElementById('countdown');

    // Установите конечное время (например, 30 мая 2025 года в 23:59:59)
    const endTime = new Date("2025-05-30T23:59:59").getTime(); 

    function pad(n) {
        return n < 10 ? '0' + n : n;
    }

    function updateTimer() {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance <= 0) {
            countdownEl.textContent = "00:00:00";
            clearInterval(timerInterval); // Останавливаем таймер
            return;
        }

        const hours = pad(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
        const minutes = pad(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
        const seconds = pad(Math.floor((distance % (1000 * 60)) / 1000));

        countdownEl.textContent = `${hours}:${minutes}:${seconds}`;
    }

    updateTimer(); 
    const timerInterval = setInterval(updateTimer, 1000); // Запускаем обновление каждую секунду
});