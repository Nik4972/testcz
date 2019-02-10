<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Просмотр данных</title>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body style="background-image:url(images/bg.jpg)">

<?php
//Соединение с БД
        require_once ('connect.php');

        $link = connect_db();
        $link->set_charset("utf8");

        if ($link->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
        }

        $un   = $_POST['username'];
        $pass = $_POST['password'];

        if ($un == 'admin' & $pass == 'admin') {

            if (!($query = $link->prepare("SELECT u.fam, u.name, u.name2, u.dr, u.email, u.username, u.password, c.name as cardname, u.created_at, (select sum(summa) from trash WHERE userid=u.id) as summa FROM users u LEFT JOIN cards c ON c.id = u.card_id WHERE u.username <> 'admin' ORDER BY summa DESC"))) {
                echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
            }

            if (!$query->execute()) {
                echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
            }

            $query->store_result();
            $row = $query->num_rows;

            if ($row === 0) {
                die('<body bgcolor=black text=red><div align="center"><h1>Неверное имя пользователя или пароль!</h1></div></body>' . mysqli_error());
            }

            $query->bind_result($fam, $name, $name2, $dr, $email, $username, $password, $cardname, $created_at, $summa);

            echo '<div align="center">';
            echo '<h3>Просмотр пльзователей</h3>';
            echo '</div>';

// Выводим заголовок таблицы:
            echo "<table border=\"1\" width=\"100%\" bgcolor=\"#FFFFA1\">";
            echo "<tr><th>Фамилия</th><th>Имя</th><th>Отчество</th>";
            echo "<th>Дата рождения</th> <th>Email</th> <th>Username</th> <th>Password</th> <th>Карта №</th> <th>Регистрация</th> <th>Сумма покупок</th></tr>";

            while ($query->fetch()) {

                echo "<tr align=center bgcolor=\"#FFFFE1\">";
                echo "<td>$fam</td><td>$name</td><td>$name2</td>";
                echo "<td>$dr</td>  <td>$email</td> <td>$username</td><td>$password</td><td>$cardname</td><td>$created_at</td><td>$summa</td>  ";
                echo "</tr>";
            }

            echo "</table>";

            echo "</br>";
            echo "Всего пользователей: " . $row;
            echo "</br>";

// Выводим отчет по базе данных

            echo '<form name="otchet" action="exel_export.php" method="post" enctype="multipart/form-data" target="_self">';
            echo '<div align="center">';
            echo '<p><h3>Формирование отчета по базе данных </h3></p>';
            echo '<p><input type="submit" value="Сформировать"></p>';
            echo '</div>';
            echo '</form>';
        }
        else {

// Вывод данных пользователя при вводе логина и пароля пользователя

            if (!($query = $link->prepare("SELECT u.id as userid, u.fam, u.name, u.name2, u.dr, u.email, u.username, u.password, c.name as cardname, u.created_at FROM users u LEFT JOIN cards c ON c.id = u.card_id WHERE u.username=? AND u.password=?"))) {
                echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
            }

            if (!$query->bind_param("ss", $un, $pass)) {
                echo "Не удалось привязать параметры: (" . $query->errno . ") " . $query->error;
            }

            if (!$query->execute()) {
                echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
            }

            $query->store_result();
            $row = $query->num_rows;

            if ($row === 0) {
                die('<body bgcolor=black text=red><div align="center"><h1>Неверное имя пользователя или пароль!</h1></div></body>' . mysqli_error());
            }

            $query->bind_result($userid, $fam, $name, $name2, $dr, $email, $username, $password, $cardname, $created_at);

            echo '<div align="center">';

            while ($query->fetch()) {

                echo "<h2>Ваши персональные данные:</h2>";
                echo "<p>Имя пользователя: <b>$username</b></p>";
                echo "<p>Пароль: <b>$password</b></p>";
                echo "<p>Фамилия: <b>$fam</b></p>";
                echo "<p>Имя: <b>$name</b></p>";
                echo "<p>Отчество: <b>$name2</b></p>";
                echo "<p>Рождение: <b>$dr</b></p>";
                echo "<p>E-Mail: <b>$email</b></p>";
                echo "<p>Карта №: <b>$cardname</b></p>";
                echo "<p>Регистрация: <b>$created_at</b></p>";
            }

// Магазин

            if (!($query = $link->prepare("SELECT id, name FROM tovar order by name"))) {
                echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
            }

            if (!$query->execute()) {
                echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
            }

            $query->bind_result($id, $name);
            ?>

        <center>
            </br>
            <div class="container">
                <legend><h3>Каталог товаров</h3></legend>
            </div>
            <!-- Формирование drop down list с названием товара и формы ввода -->

            <form method="POST" id="formx" action="javascript:void(null);" onsubmit="call()">

                <label for="tovar">Товар</label>

                <select name='tovar'>
            <?php
            while ($query->fetch()) {
                echo "<option value=$id>$name</option>";
            }
            ?>
                </select>

                <label for="kol">Количество</label>
                <input id="kol" name="kol" value="1" type="text">
                <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>">
                <input value="Купить" type="submit">
            </form>
            </br></br></br>
        </center>    

        <!-- Вывод содержимого корзины -->
        <div id="results"></div> 

        <center><p>&copy; 2019 KNN Dnipro<p></center> 

<?php
           }
?>
</body>
</html>

