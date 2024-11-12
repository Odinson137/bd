<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require_once("config.php");

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $query = "DELETE FROM users WHERE id = $user_id";
    if (mysqli_query($dbcnx, $query)) {
        header("Location: manage_users.php");
    } else {
        echo "Ошибка при удалении пользователя!";
    }
}
?>
