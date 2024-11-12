<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require_once("config.php");

$query = "SELECT * FROM users";
$result = mysqli_query($dbcnx, $query);

echo "<table>";
echo "<tr><th>ID</th><th>Логин</th><th>Email</th><th>Роль</th><th>Удалить</th></tr>";
while ($user = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . $user['id'] . "</td><td>" . $user['username'] . "</td><td>" . $user['email'] . "</td><td>" . $user['role'] . "</td>";
    echo "<td><a href='delete_user.php?id=" . $user['id'] . "'>Удалить</a></td></tr>";
}
echo "</table>";
?>
