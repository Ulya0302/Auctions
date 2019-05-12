<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="css/form-style.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
<a class="simplebtn" href="login.php">У меня уже есть аккаунт, хочу войти</a>
<hr>
<?php
include_once("db/db_conn_open.php");
include_once('utils.php');
session_start();
if (isset($_SESSION['user'])) {
    header('Location: auctions_stat.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query =
        "INSERT INTO users(username, password)
        VALUES ('$username', '$password')";
    $res = $conn->query($query);
    if ($res == true) {
        header('Location: login.php?success=true');
    } else {
        if ($conn->errno == 1062) {
            error("Зарегистрироваться не удалось: такой логин уже существует");
        } else {
            error("Зарегистрироваться не удалось: непредвиденная ошибка");
        }
    }

}
?>
<form class="main-form width-60" action="registration.php" method="POST">
    <h4 align="center">Зарегистрироваться</h4>
    <p><label for="username">Логин: </label>
        <input class="form-input" minlength="4" type="text" id="username" name="username" required></p>
    <p><label for="password">Пароль: </label>
        <input class="form-input" minlength="4" type="password" id="password" name="password" required></p>
    <input class="submit-btn" type="submit" name="register" value="Создать">
</form>
</body>
</html>
