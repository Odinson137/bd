<?php
$dblocation = "db";
$dbname = "jewelry_workshop";
$dbuser = "root";
$dbpasswd = "rootpassword";

// Подключение к серверу базы данных
$dbcnx = @mysqli_connect($dblocation, $dbuser, $dbpasswd);
if (!$dbcnx) {
    echo "<p>В настоящий момент сервер базы данных не доступен, поэтому корректное отображение страницы невозможно.</p>";
    exit();
}

// Подключение к базе данных
if (!@mysqli_select_db($dbcnx, $dbname)) {
    echo "<p>В настоящий момент база данных не доступна, поэтому корректное отображение страницы невозможно.</p>";
    exit();
}

echo "<p>Успешное подключение к базе данных</p>";
?>
