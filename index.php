<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Вход/Регистрации</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">

        <link rel="shortcut icon" href="/images/group.ico" type="image/x-icon">
        <script type="text/javascript" src="js/script.js"></script>

    </head>

    <body style="background-image:url(images/bg.jpg)">

        <form id="login" method="post" action="prosmotr_profil.php">
            <h1>WELCOME</h1>
            <fieldset id="inputs">
                <input name="username" type="text" placeholder="Логин" autofocus required>
                <input name="password" type="password" placeholder="Пароль" required>
            </fieldset>
            <fieldset id="actions">
                <input type="submit" id="submit" value="ВОЙТИ">
                <a href="registraciya.php">Регистрация</a>
            </fieldset>
        </form>

</body>
</html>
