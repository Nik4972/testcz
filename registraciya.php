<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Регистрация</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
    </head>

    <body background="images/bg.jpg">

        <?php
        require_once ('connect.php');

        $link = connect_db();
        $link->set_charset("utf8");

        if ($link->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
        }

        if (!($query = $link->prepare("SELECT id, name FROM cards WHERE status=0"))) {
            echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
        }

        if (!$query->execute()) {
            echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
        }

        $query->bind_result($id, $name);
        ?>

        <form name="form1" method="post" action="insert_to_bd.php">

            <h3>Введите ваши данные</h3>

            <div class="main">
                <div class="field">
                    <label for="n">Имя пользователя</label>
                    <input type="text" id="n" name="username" />
                </div>
                <div class="field">
                    <label for="n1">Пароль</label>
                    <input type="text" id="n1" name="password" />
                </div>
                <div class="field">
                    <label for="n2">Фамилия</label>
                    <input type="text" id="n2" name="fam" />
                </div>
                <div class="field">
                    <label for="n3">Имя</label>
                    <input type="text" id="n3" name="name" />
                </div>
                <div class="field">
                    <label for="n4">Отчество</label>
                    <input type="text" id="n4" name="name2" />
                </div>
                <div class="field">
                    <label for="n5">Дата роджения</label>
                    <input type="text" id="n5" name="dr" />
                </div>
                <div class="field">
                    <label for="n6">E-Mail</label>
                    <input type="text" id="n6" name="email" />
                </div>
                <div class="field">
                    <label for="n7">Карта лояльности</label>
                    <select id="n7" name='card'>
                    <?php
                      while ($query->fetch()) {
                          echo "<option value=$id>$name</option>";
                      }
                    ?>
                    </select>
                </div>

                 <input type="hidden" id="cardname" name="cardname" value="<?php echo $name; ?>">

                <input type="submit" value="Сохранить">
            </div>


        </form>
    </body>
</html>
