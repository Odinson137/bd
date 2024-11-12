<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>

<h1>Панель администратора</h1>
<a href="manage_users.php">Управление пользователями</a>
<a href="manage_texts.php">Управление текстами</a>
