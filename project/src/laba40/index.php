<?php
require_once 'config.php';

try {
    // Создание объекта PDO
    $pdo = new PDO("mysql:host=$dblocation;dbname=$dbname;charset=utf8", $dbuser, $dbpasswd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Добавление продукта
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $material_id = $_POST['material_id'];
        $weight = $_POST['weight'];
        $price = $_POST['price'];
        $query = $pdo->prepare("
            INSERT INTO Products (name, category_id, material_id, weight, price) 
            VALUES (:name, :category_id, :material_id, :weight, :price)
        ");
        $query->execute([
            'name' => $name,
            'category_id' => $category_id,
            'material_id' => $material_id,
            'weight' => $weight,
            'price' => $price,
        ]);
        echo "Продукт добавлен!<br>";
    }

    // Удаление продукта
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
        $id = $_POST['id'];
        $query = $pdo->prepare("DELETE FROM Products WHERE id = :id");
        $query->execute(['id' => $id]);
        echo "Продукт удален!<br>";
    }

    // Обновление продукта
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $query = $pdo->prepare("UPDATE Products SET name = :name, price = :price WHERE id = :id");
        $query->execute(['id' => $id, 'name' => $name, 'price' => $price]);
        echo "Продукт обновлен!<br>";
    }
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>

<h3>Добавить продукт</h3>
<form method="POST">
    Название: <input type="text" name="name" required>
    Категория ID: <input type="number" name="category_id">
    Материал ID: <input type="number" name="material_id">
    Вес (грамм): <input type="number" name="weight" step="0.01">
    Цена: <input type="number" name="price" step="0.01" required>
    <button type="submit" name="add_product">Добавить</button>
</form>

<h3>Удалить продукт</h3>
<form method="POST">
    ID продукта: <input type="number" name="id" required>
    <button type="submit" name="delete_product">Удалить</button>
</form>

<h3>Изменить продукт</h3>
<form method="POST">
    ID продукта: <input type="number" name="id" required>
    Название: <input type="text" name="name" required>
    Цена: <input type="number" name="price" step="0.01" required>
    <button type="submit" name="update_product">Изменить</button>
</form>

<h3>Фильтр продуктов</h3>
<form method="GET">
    Название: <input type="text" name="name">
    Минимальная цена: <input type="number" name="min_price" step="0.01">
    Максимальная цена: <input type="number" name="max_price" step="0.01">
    <button type="submit" name="search_product">Найти</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search_product'])) {
    $name = $_GET['name'] ?? '';
    $minPrice = $_GET['min_price'] ?? 0;
    $maxPrice = $_GET['max_price'] ?? PHP_INT_MAX;

    $query = $pdo->prepare("
        SELECT Products.*, Categories.name AS category_name, Materials.name AS material_name 
        FROM Products
        LEFT JOIN Categories ON Products.category_id = Categories.id
        LEFT JOIN Materials ON Products.material_id = Materials.id
        WHERE Products.name LIKE :name AND Products.price BETWEEN :minPrice AND :maxPrice
    ");
    $query->execute([
        'name' => '%' . $name . '%',
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
    ]);

    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        foreach ($results as $product) {
            echo "<div>";
            echo "ID: " . $product['id'] . "<br>";
            echo "Название: " . $product['name'] . "<br>";
            echo "Категория: " . $product['category_name'] . "<br>";
            echo "Материал: " . $product['material_name'] . "<br>";
            echo "Вес: " . $product['weight'] . " г<br>";
            echo "Цена: " . $product['price'] . " руб<br>";
            echo "</div><hr>";
        }
    } else {
        echo "Продуктов не найдено.";
    }
}
?>
