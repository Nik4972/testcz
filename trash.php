<?php

//Соединение с БД
require_once ('connect.php');
$link = connect_db();
$link->set_charset("utf8");

if ($link->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
}

//Проверка валидности количества товара
if (!is_numeric($_POST["kol"]) || $_POST["kol"] == 0) {

    echo '<center>';
    echo '<h3 style="color:red">Неверное количество товара!</h3>';
    echo '</center>';
}
else {

//Добавление в корзину нового товара
//Получение стоимости товара
    if (!($query = $link->prepare("SELECT name, price FROM tovar WHERE id=?"))) {
        echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
    }
    if (!$query->bind_param("i", $_POST['tovar'])) {
        echo "Не удалось привязать параметры: (" . $query->errno . ") " . $query->error;
    }
    if (!$query->execute()) {
        echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
    }

    $query->bind_result($name, $price);
    $query->fetch();

//Вставка в корзину нового товара

    $link = connect_db();
    $link->set_charset("utf8");

    if ($link->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
    }

    if (!($query = $link->prepare("INSERT INTO trash(userid,tovarid,name,kol,price,summa,created_at) VALUES (?,?,?,?,?,?,now())"))) {
        echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
    }

    $summa = $_POST['kol'] * $price;

    if (!$query->bind_param("iisiii", $_POST['userid'], $_POST['tovar'], $name, $_POST['kol'], $price, $summa)) {
        echo "Не удалось привязать параметры: (" . $query->errno . ") " . $query->error;
    }

    if (!$query->execute()) {
        echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
    }
}


// Вывод содержимого корзины

if (!($query = $link->prepare("SELECT id, tovarid, name, kol, price, summa, created_at FROM trash WHERE userid=?"))) {
    echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
}

if (!$query->bind_param("i", $_POST['userid'])) {
    echo "Не удалось привязать параметры: (" . $query->errno . ") " . $query->error;
}

if (!$query->execute()) {
    echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
}

$query->bind_result($id, $tovarid, $name, $kol, $price, $summa, $created_at);

echo "<center><h1>Ваши покупки<h1></center>";
echo "<table class=\"table table-bordered\" border=\"1\" width=\"100%\" bgcolor=\"#FFFFA1\">";
echo '<tr><th style="text-align:center">Товар</th><th style="text-align:center">Количество</th><th style="text-align:center">Цена</th>';
echo '<th style="text-align:center">Сумма</th><th style="text-align:center">Дата покупки</th> </tr>';

$itogo = 0;

while ($query->fetch()) {
    $itogo = $itogo + $summa;
    echo "<tr align=center bgcolor=\"#FFFFE1\">";
    echo "<td>$name</td><td>$kol</td><td>$price</td>";
    echo "<td>$summa</td>";
    echo "<td>$created_at</td>";
    echo "</tr>";
}
echo "</table>";
echo "</br></br></br>";

echo "<h3>Итого: " . $itogo . "</h3></br>";
?>





