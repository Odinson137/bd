<!DOCTYPE html>
<html>
<head>
    <title>Поиск ювелирного изделия</title>
</head>
<body>
<h1>Поиск изделий в каталоге</h1>
<form action="results.php" method="post">
    Выберите параметр поиска:<br>
    <select name="searchtype">
        <option value="client_name">Имя клиента</option>
        <option value="product_name">Название изделия</option>
        <option value="order_date">Дата заказа</option>
    </select><br>
    Введите параметры поиска:<br>
    <input name="searchterm" type="text"><br>
    <input type="submit" value="Поиск">
</form>
</body>
</html>
