<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Войти</title>
    <link rel="stylesheet" type="text/css" href="css/form-style.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
<a class="simplebtn" href="registration.php">Зарегистрироваться</a>
<hr>
<?php
include_once("db/db_conn_open.php");
include_once('utils.php');
session_start();
if (isset($_SESSION['user'])) {
    header('Location: auctions_stat.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query =
        "SELECT count(username) c FROM users WHERE username='{$_POST['username']}'";
    $res = $conn->query($query) or die("Непредвиденная ошибка");
    $row = $res->fetch_assoc();
    $res->free_result();
    if ($row['c'] == 0) {
        error("Пользователя с таким логином не существует");
    } else {
        $query =
            "SELECT username, password FROM users WHERE username='{$_POST['username']}'";
        $res = $conn->query($query) or die("Непредвиденная ошибка");
        $row = $res->fetch_assoc();
        if ($row['password'] == md5($_POST['password'])) {
            $_SESSION['user'] = $row['username'];
            header("Location: auctions_stat.php");
        } else {
            error("Неправильный пароль");
        }
    }
}

if (isset($_GET['success'])) {
    if ($_GET['success'] == true) {
        success("Вы успешно зарегистрированы. Теперь войдите");
    }
}
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        success("Вы успешно вышли, возвращайтесь");
    }
}
?>
<form class="main-form width-60" action="login.php" method="POST">
    <h4 align="center">Войти</h4>
    <p><label for="username">Логин: </label>
        <input pattern="[\dA-Za-zА-Яа-я]*" maxlength="30" placeholder="Только буквы и цифры" class="form-input"
               type="text" id="username" name="username" required></p>
    <p><label for="password">Пароль: </label>
        <input pattern="[\dA-Za-zА-Яа-я]*" maxlength="30" class="form-input" placeholder="Максимальная длина: 30"
               type="password" id="password" name="password" required></p>
    <input class="submit-btn" type="submit" name="register" value="Войти">
</form>
</body>
</html>
