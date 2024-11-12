<?php
// Подключение к базе данных через ваш файл
require_once("config.php");

// Проверка подключения
if (!$dbcnx) {
    exit("Ошибка подключения к базе данных.");
}

// Выполняем запрос для получения данных из таблицы (замените 'products' на свою таблицу)
$query = "SELECT * FROM Products";
$result = mysqli_query($dbcnx, $query);

// Проверка, что запрос выполнен успешно
if (!$result) {
    exit("Ошибка выполнения запроса.");
}

// Подключаем FPDF
require('libs/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Получение и отображение заголовков столбцов таблицы
$columns_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                  WHERE TABLE_SCHEMA = 'jewelry_workshop' 
                  AND TABLE_NAME = 'products'";
$columns_result = mysqli_query($dbcnx, $columns_query);

if ($columns_result) {
    // Выводим заголовки столбцов
    while ($column = mysqli_fetch_assoc($columns_result)) {
        $pdf->Cell(40, 10, $column['COLUMN_NAME'], 1);
    }
    $pdf->Ln(); // Новая строка после заголовков
}

// Заполнение таблицы данными из БД
$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $data) {
        $pdf->Cell(40, 10, $data, 1);
    }
    $pdf->Ln();
}

// Вывод PDF
$pdf->Output('I', 'report.pdf');
exit();  // Завершаем скрипт, чтобы предотвратить лишний вывод
?>
