<?php
include "config.php";  // Подключаем файл конфигурации для соединения с БД

// Обработка запроса на изменение стоимости
if (isset($_POST['update_price'])) {
    $product_type = $_POST['product_type'];
    $article = $_POST['article'];
    $new_price = $_POST['new_price'];
    $date = $_POST['date'];
    
    if ($product_type && $article && $new_price && $date) {
        $query = "UPDATE Products
                  SET price = ?
                  WHERE name = ? AND article = ? AND DATE(purchase_date) = ?";
        
        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param('dsss', $new_price, $product_type, $article, $date);
        
        if ($stmt->execute()) {
            echo "<p>Стоимость изделия успешно обновлена.</p>";
        } else {
            echo "<p>Ошибка при обновлении стоимости: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>Пожалуйста, заполните все поля для изменения стоимости.</p>";
    }
}

// Обработка запроса на изменение названия
if (isset($_POST['update_name'])) {
    $old_name = $_POST['old_name'];
    $new_name = $_POST['new_name'];
    
    if ($old_name && $new_name) {
        $query = "UPDATE Products
                  SET name = ?
                  WHERE name = ?";
        
        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param('ss', $new_name, $old_name);
        
        if ($stmt->execute()) {
            echo "<p>Название изделия успешно обновлено.</p>";
        } else {
            echo "<p>Ошибка при обновлении названия: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>Пожалуйста, заполните текущее и новое название для изменения.</p>";
    }
}
?>
