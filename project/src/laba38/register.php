<?php
require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $email = trim($_POST['email']); // Новый ввод
    $role = 'user'; // по умолчанию обычный пользователь

    $query = "INSERT INTO users (username, password, role, email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbcnx, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $username, $password, $role, $email);

    if (mysqli_stmt_execute($stmt)) {
        // Отправка письма
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Замените на ваш SMTP сервер
        $mail->SMTPAuth = true;
        $mail->Username = 'sanya.baginsky@gmail.com'; // Замените на вашу почту
        $mail->Password = 'vdsi ujwl keda uxsc'; // Пароль к почте
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('sanya.baginsky@gmail.com', 'Ваш Сервис'); // От кого
        $mail->addAddress($email, $username); // Кому
        $mail->Subject = 'Регистрация успешна';
        $mail->Body = "Send me nuds, $username!\n\n and it was sending from laba38.";

        if ($mail->send()) {
            echo "Регистрация успешна! Письмо отправлено на $email.";
        } else {
            echo "Регистрация успешна, но возникла ошибка при отправке письма.";
        }
    } else {
        echo "Ошибка регистрации.";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="email" name="email" placeholder="Электронная почта" required>
    <button type="submit">Зарегистрироваться</button>
</form>
