<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <footer class="footer bg-info text-white py-4 mt-5" id="footer">
        <div class="container text-center" id="footer_container">
            <div class="footer_logo">
                <img class="footer_logo" src="./image/logo_bike.png" style="width: 200px; height: 200px;" alt="logo_bike_shop">
                <p class="p_logo"><?php echo "CycloShop"; ?></p>
            </div>
            <div class="footer_social">
                <h4 class="mb-3">Основные сведения о магазине</h4>
                <p class="mb-1">Адрес магазина: ул. Велосипедная, 10, г. Набережные Челны</p>
                <p class="mb-0">По всем вопросам обращаться по номеру: <a href="tel:+78001234567"><strong>8-800-123-45-67</strong></a></p>
                <p class="mb-1">Социальные сети: 
                    <a href="https://facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://instagram.com" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="https://youtube.com" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="https://linkedin.com" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://pinterest.com" target="_blank" class="social-icon"><i class="fab fa-pinterest"></i></a>
                    <a href="https://tiktok.com" target="_blank" class="social-icon"><i class="fab fa-tiktok"></i></a>
                </p>
            </div>
        </div>
        <div class="footer_map mt-4">
                <h4>Наши координаты</h4>
                <div class="map-container" style="width: 100%; height: 300px; border: 1px solid #ccc;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224107.98210504088!2d37.61763599999999!3d55.755826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b5b3d7f6be4a91%3A0xa6f89761a90f2e65!2z0YPQu9C40YHRgtCw0Y8sINCU0YHRj9Cw0YnQs9Cw!5e0!3m2!1sru!2sru!4v1682542566009!5m2!1sru!2sru" 
                        width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
    </footer>
</body>
</html>
