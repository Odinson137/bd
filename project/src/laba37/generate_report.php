<?php
// Подключение к базе данных
include "config.php";  // Подключаем файл конфигурации для соединения с БД

// Выполняем запрос для получения данных
$query = "SELECT * FROM Products"; // Замените Products на название вашей таблицы
$result = mysqli_query($dbcnx, $query);

if (!$result) {
    die("Ошибка выполнения запроса: " . mysqli_error($dbcnx));
}

// Имя файла для сохранения отчёта
$filename = 'report.txt';

// Открываем файл для записи
$file = fopen($filename, 'w');
if (!$file) {
    die("Не удалось открыть файл для записи.");
}

// Добавляем заголовок
fwrite($file, "Отчёт из базы данных\n");
fwrite($file, str_repeat('=', 50) . "\n");

// Получаем названия столбцов
$columns_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                  WHERE TABLE_SCHEMA = 'jewelry_workshop' 
                  AND TABLE_NAME = 'Products'";
$columns_result = mysqli_query($dbcnx, $columns_query);

if ($columns_result) {
    $columns = [];
    while ($column = mysqli_fetch_assoc($columns_result)) {
        $columns[] = $column['COLUMN_NAME'];
    }

    // Записываем заголовки столбцов в файл
    fwrite($file, implode("\t", $columns) . "\n");
    fwrite($file, str_repeat('-', 50) . "\n");
}

// Записываем данные в файл
while ($row = mysqli_fetch_assoc($result)) {
    fwrite($file, implode("\t", $row) . "\n");
}

// Закрываем файл
fclose($file);

// Устанавливаем заголовки для скачивания файла
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Отправляем файл в браузер
readfile($filename);

// Удаляем временный файл после отправки

exit;
?>
