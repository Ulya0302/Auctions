<html>
<head>
    <meta charset="utf-8">
    <title>Добавить участника</title>
    <link type="text/css" href="css/form-style.css" rel="stylesheet">
    <link type="text/css" href="css/common.css" rel="stylesheet">
    <?php include_once("db/db_conn_open.php"); ?>
    <?php include_once("utils.php"); ?>
</head>
<body>
<?php include_once("menu.php") ?>
<form class="main-form width-40" id="new_part" method="POST" action="add_participant.php">
    <h2 id="title" align="center">Новый участник</h2>
    <input id="part_id" name="part_id" hidden>
    <p><label>Имя <input class="form-input" id="name" name="name" type="text" required/></label></p>
    <p><label>Номер <input class="form-input" id="phone" name="phone" type="tel" placeholder="+79001231212"
                           pattern="[+]{0,1}[0-9]{11,14}" required/></label></p>
    <p><label>E-mail <input class="form-input" id="email" name="email" type="email" required/></label></p>
    <input id="submit-btn" class="submit-btn" type="submit" value="Создать">
</form>

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['part_id']) && $_POST['part_id'] != "") {
        $query =
            "UPDATE participants SET
               name = '{$_POST['name']}',
               phone = '{$_POST['phone']}',
               email = '{$_POST['email']}'
            WHERE id = {$_POST['part_id']}";
        $result = $conn->query($query);
        if ($result === true) {
            alert('Изменено');
        } else {
            echo $conn->error;
            alert('Не удалось изменить');
        }
    } else {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $query =
            "INSERT INTO participants(name, phone, email) 
        VALUES ('$name','$phone', '$email')";
        $result = $conn->query($query);
        if ($result == true) {
            alert('Новая запись добавлена успешно');
        } else {
            alert('Ошибка, добавить запись не удалось');
        }
    }
}
elseif (isset($_GET['id'])) {
    $query =
        "SELECT name, phone, email
        FROM participants 
        WHERE id = {$_GET['id']}";
    $result = $conn->query($query);
    if ($result == true) {
        $row = $result->fetch_assoc();
        echo "<script>
                    document.getElementById('title').textContent = 'Изменение участника';
                    document.getElementById('name').value = '{$row['name']}';
                    document.getElementById('phone').value = '{$row['phone']}';
                    document.getElementById('email').value = '{$row['email']}';
                    document.getElementById('part_id').value = '{$_GET['id']}';
                    document.getElementById('submit-btn').value = 'Сохранить';
               </script>";
        $result->free_result();

    } else {
        alert('Не удалось загрузить данные: {$conn->error}');
    }
}

?>