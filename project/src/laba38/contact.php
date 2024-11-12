<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Вы должны быть авторизованы, чтобы отправить сообщение.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    require_once("config.php");

    // Сохранение сообщения в базе данных
    $query = "INSERT INTO messages (user_id, name, email, message) VALUES ('" . $_SESSION['user_id'] . "', '$name', '$email', '$message')";
    if (mysqli_query($dbcnx, $query)) {
        echo "Ваше сообщение отправлено!";
    } else {
        echo "Ошибка при отправке сообщения!";
    }

    // Отправка email
    $subject = "Обратная связь с сайта";
    $to = "admin@example.com";
    $headers = "From: $email";
    mail($to, $subject, $message, $headers);
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Представьтесь" required>
    <input type="email" name="email" placeholder="Ваш E-mail" required>
    <textarea name="message" placeholder="Текст сообщения" required></textarea>
    <button type="submit">Отправить</button>
</form>
