<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

require_once("config.php");

$query = "SELECT * FROM messages";
$result = mysqli_query($dbcnx, $query);

echo "<table>";
echo "<tr><th>ID</th><th>Имя</th><th>Email</th><th>Сообщение</th></tr>";
while ($message = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . $message['id'] . "</td><td>" . $message['name'] . "</td><td>" . $message['email'] . "</td><td>" . $message['message'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
