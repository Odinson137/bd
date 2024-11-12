<?php
include "config.php";  // Подключаем файл конфигурации для соединения с БД

// Обработка запроса на добавление нового изделияё
if (isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $article = $_POST['article'];
    $price = $_POST['price'];
    $purchase_date = $_POST['purchase_date'];

    if ($item_name && $article && $price && $purchase_date) {
        $query = "INSERT INTO Products (name, article, price, purchase_date)
                  VALUES (?, ?, ?, ?)";

        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param('ssds', $item_name, $article, $price, $purchase_date);

        if ($stmt->execute()) {
            echo "<p>Новое изделие успешно добавлено.</p>";
        } else {
            echo "<p>Ошибка при добавлении изделия: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>Пожалуйста, заполните все поля для добавления изделия.</p>";
    }
}

// Обработка запроса на удаление изделия по артикулу
if (isset($_POST['delete_item'])) {
    $delete_article = $_POST['delete_article'];

    if ($delete_article) {
        $query = "DELETE FROM Products WHERE article = ?";

        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param('s', $delete_article);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<p>Изделие с артикулом $delete_article успешно удалено.</p>";
            } else {
                echo "<p>Изделие с артикулом $delete_article не найдено.</p>";
            }
        } else {
            echo "<p>Ошибка при удалении изделия: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>Пожалуйста, введите артикул изделия для удаления.</p>";
    }
}
?>
