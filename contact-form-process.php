<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Настройка email
    $email_to = "d-yut@mail.ru"; // Email из contacts.html
    $email_subject = "Новое сообщение с сайта Энерго-сервис";

    // Функция для обработки ошибок
    function show_error($error) {
        header("Location: contacts.html?status=error");
        exit();
    }

    // Проверка заполненности обязательных полей
    if (empty($_POST['name']) || empty($_POST['message'])) {
        show_error("Пожалуйста, заполните все обязательные поля.");
    }

    // Получение и очистка данных
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $phone = !empty($_POST['phone']) ? filter_var($_POST['phone'], FILTER_SANITIZE_STRING) : "Не указан";
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Формирование тела письма
    $email_message = "Новое сообщение от:\n\n";
    $email_message .= "Имя: " . $name . "\n";
    $email_message .= "Телефон: " . $phone . "\n";
    $email_message .= "Сообщение: " . $message . "\n";

    // Заголовки письма
    $headers = "From: noreply@energoservis.ru\r\n";
    $headers .= "Reply-To: no-reply@energoservis.ru\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Отправка письма
    if (mail($email_to, $email_subject, $email_message, $headers)) {
        header("Location: contacts.html?status=success");
    } else {
        show_error("Не удалось отправить письмо. Попробуйте позже.");
    }
} else {
    header("Location: contacts.html?status=error");
}
?>