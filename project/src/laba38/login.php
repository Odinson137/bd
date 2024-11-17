<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($dbcnx, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // Вывод для админа
            if ($row['role'] === 'admin') {
                echo "<h1>Добро пожаловать, Администратор {$row['username']}</h1>";
                echo "<h2>Список пользователей:</h2>";

                $usersQuery = "SELECT id, username, role FROM users";
                $usersResult = mysqli_query($dbcnx, $usersQuery);

                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Имя пользователя</th><th>Роль</th></tr>";
                while ($userRow = mysqli_fetch_assoc($usersResult)) {
                    echo "<tr>";
                    echo "<td>{$userRow['id']}</td>";
                    echo "<td>{$userRow['username']}</td>";
                    echo "<td>{$userRow['role']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
                exit;
            }

            // Вывод для обычного пользователя
            echo "<h1>Вы не администратор, {$row['username']}!</h1>";
            echo "<p>У вас нет доступа к админ-панели.</p>";
            exit;
        }
    }

    echo "Неверные имя пользователя или пароль.";
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
</form>
