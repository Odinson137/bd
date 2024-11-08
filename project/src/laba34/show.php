<?php
include "config.php";

$query = "SELECT Orders.id AS order_id,
                 Clients.name AS client_name,
                 Products.name AS product_name,
                 Orders.order_date,
                 Orders.quantity,
                 Orders.total_price
          FROM Orders
          JOIN Clients ON Orders.client_id = Clients.id
          JOIN Products ON Orders.product_id = Products.id";

$result = mysqli_query($dbcnx, $query);

echo "<h1>Заказы</h1>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p><strong>Заказ №" . $row['order_id'] . "</strong><br>";
    echo "Клиент: " . htmlspecialchars($row['client_name']) . "<br>";
    echo "Изделие: " . htmlspecialchars($row['product_name']) . "<br>";
    echo "Дата заказа: " . htmlspecialchars($row['order_date']) . "<br>";
    echo "Количество: " . htmlspecialchars($row['quantity']) . "<br>";
    echo "Общая цена: " . htmlspecialchars($row['total_price']) . "</p>";
}
?>
