<?php
// 1. Подключение к базе данных с помощью PDO
$host = 'db';
$dbname = 'jewelry_workshop';
$user = 'root';
$password = 'rootpassword';

try {
    // Создание объекта PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Успешное подключение к базе данных<br>";

    // 2. Вывод названий всех таблиц БД
    echo "<h3>Список таблиц в базе данных:</h3>";
    $tablesQuery = $pdo->query("SHOW TABLES");
    $tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);
    
    if (!empty($tables)) {
        foreach ($tables as $table) {
            echo "- $table<br>";
        }
    } else {
        echo "Таблицы в базе данных отсутствуют.<br>";
    }

    // 3. Вывод данных из таблицы с использованием плейсхолдеров
    // Выбираем первую таблицу
    if (!empty($tables)) {
        $selectedTable = $tables[0];
        echo "<h3>Данные из таблицы '$selectedTable':</h3>";

        // Позиционные плейсхолдеры
        $query = $pdo->prepare("SELECT * FROM $selectedTable WHERE id > ?");
        $query->execute([0]); // Передаём значение плейсхолдера
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            echo "<pre>" . print_r($row, true) . "</pre>";
        }

        // Именованные плейсхолдеры
        $query = $pdo->prepare("SELECT * FROM $selectedTable WHERE id = :id");
        $query->execute(['id' => 1]); // Передаём значение плейсхолдера
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Данные с использованием именованных плейсхолдеров:</h3>";
        foreach ($rows as $row) {
            echo "<pre>" . print_r($row, true) . "</pre>";
        }
    }

} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
