<?php
require_once("config.php"); // подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($dbcnx, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // хеширование пароля
    $email = mysqli_real_escape_string($dbcnx, $_POST['email']);
    
    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    if (mysqli_query($dbcnx, $query)) {
        echo "Регистрация прошла успешно!";
    } else {
        echo "Ошибка при регистрации!";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Зарегистрироваться</button>
</form>
