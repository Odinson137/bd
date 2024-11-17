<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $role = 'user'; // по умолчанию обычный пользователь

    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($dbcnx, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $username, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        echo "Регистрация успешна!";
    } else {
        echo "Ошибка регистрации.";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Зарегистрироваться</button>
</form>
