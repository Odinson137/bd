<?php
include "config.php";

$searchtype = trim($_POST['searchtype']);
$searchterm = trim($_POST['searchterm']);

if (!$searchtype || !$searchterm) {
    echo "Вы не ввели критерии поиска. Вернитесь назад и попробуйте еще раз.";
    exit();
}

// Защита от некорректных значений searchtype
$allowedSearchTypes = ['client_name', 'product_name', 'order_date'];
if (!in_array($searchtype, $allowedSearchTypes)) {
    echo "Некорректный параметр поиска.";
    exit();
}

// Преобразование searchtype к реальному названию столбца
switch ($searchtype) {
    case 'client_name':
        $searchtype = 'Clients.name';
        break;
    case 'product_name':
        $searchtype = 'Products.name';
        break;
    case 'order_date':
        $searchtype = 'Orders.order_date';
        break;
}

$searchterm = addslashes($searchterm);

$query = "SELECT Orders.id AS order_id,
                 Clients.name AS client_name,
                 Products.name AS product_name,
                 Orders.order_date,
                 Orders.quantity,
                 Orders.total_price
          FROM Orders
          JOIN Clients ON Orders.client_id = Clients.id
          JOIN Products ON Orders.product_id = Products.id
          WHERE $searchtype LIKE '%$searchterm%'";

$result = mysqli_query($dbcnx, $query);
$num_results = mysqli_num_rows($result);

echo "<h1>Результаты поиска</h1>";
echo "<p>Найдено записей: " . $num_results . "</p>";

for ($i = 0; $i < $num_results; $i++) {
    $row = mysqli_fetch_assoc($result);
    echo "<p><strong>Заказ №" . ($i + 1) . "</strong><br>";
    echo "Клиент: " . htmlspecialchars($row['client_name']) . "<br>";
    echo "Изделие: " . htmlspecialchars($row['product_name']) . "<br>";
    echo "Дата заказа: " . htmlspecialchars($row['order_date']) . "<br>";
    echo "Количество: " . htmlspecialchars($row['quantity']) . "<br>";
    echo "Общая цена: " . htmlspecialchars($row['total_price']) . "</p>";
}
?>
