<?php
require_once('db.php');
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //email из формы
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);   
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Пример подключения к базе данных
        $conn = openDbConnection();
        // Проверка подключения
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        //]email] в БД
        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            // Подготовка и отправка email
            $mail = new PHPMailer(true);

            try {
                // Настройка сервера
                $mail->isSMTP();
                $mail->Host = 'smtp.yandex.ru';
                //адрес SMTP-сервера
                $mail->SMTPAuth   = true;                 
                $mail->Username   = 'inna6903zaharova@yandex.ru'; 
                $mail->Password   = '';     
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port       = 587;               
                // Получатели
                $mail->setFrom('from@example.com', 'Mailer'); 
                $mail->addAddress($email);                  
                // Контент
                $mail->isHTML(true);
                $mail->Subject = 'Подтверждение подписки на новости';
                $mail->Body    = 'Спасибо за подписку на наши новости!';
                $mail->send();
                echo "Вы успешно подписались на новости!";
            } catch (Exception $e) {
                echo "Не удалось отправить сообщение. Ошибка: {$mail->ErrorInfo}";
            }
        } else {
            echo "Ошибка при добавлении email в базу данных.";
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "Некорректный адрес электронной почты.";
    }
} else {
    echo "Неверный метод запроса.";
}
?>









