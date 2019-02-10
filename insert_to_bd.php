<?php

echo '<html>';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
echo '<title>Вставка записи</title>';
echo '</head>';
echo '<body style="background-image:url(images/bg.jpg)">';


echo "<p>Пользователь: <b>" . $_POST['username'] . "</b></p>";
echo "<p>Пароль: <b>" . $_POST['password'] . "</b></p>";
echo "<p>Фамилия: <b>" . $_POST['fam'] . "</b></p>";
echo "<p>Имя: <b>" . $_POST['name'] . "</b></p>";
echo "<p>Отчество: <b>" . $_POST['name2'] . "</b></p>";
echo "<p>Дата рождения: <b>" . $_POST['dr'] . "</b></p>";
echo "<p>E-Mail: <b>" . $_POST['email'] . "</b></p>";
echo "<p>Карта №: <b>" . $_POST['cardname'] . "</b></p>";

$email = $_POST['email'];

// Проверяем валидность e-mail 

if (!preg_match("|^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is", strtolower($email))) {

    echo '<p><h3>Вы ввели не корректный адрес емейл! Повторите ввод, пожалуйста.</h3></p>';
}
else {

    require_once ('connect.php');

    $link = connect_db();
    $link->set_charset("utf8");

    if ($link->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
    }
    //  Registration a new user
    if (!($query = $link->prepare("INSERT INTO users (id, fam, name, name2, dr, email, username, password, card_id, created_at) VALUES ('',?,?,?,?,?,?,?,?, now())"))) {
        echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
    }


    if (!$query->bind_param("sssssssi", $_POST['fam'], $_POST['name'], $_POST['name2'], $_POST['dr'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['card'])) {
        echo "Не удалось привязать параметры: (" . $query->errno . ") " . $query->error;
    }

    if (!$query->execute()) {
        echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
    }
    else {
        echo "<p>Данные успешно записаны в базу данных.</p>";
    }
}

// Change card status
    if (!($query = $link->prepare("UPDATE cards set status=1 WHERE id=?"))) {
        echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
    }

    if (!$query->bind_param("i", $_POST['card'])) {
        echo "Не удалось привязать параметры: (" . $query->errno . ") " . $query->error;
    }

    if (!$query->execute()) {
        echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
    }

echo "</body>";
echo "</html>";

?>
