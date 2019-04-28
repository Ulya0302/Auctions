<html>
<head>
    <meta charset="utf-8">
    <title>Добавить место</title>
    <link type="text/css" href="css/form-style.css" rel="stylesheet">
    <link type="text/css" href="css/common.css" rel="stylesheet">
    <?php include_once("db/db_conn_open.php"); ?>
    <?php include_once("utils.php"); ?>
</head>
<body>
<?php include_once("menu.php") ?>
<form class="main-form width-40" id="new_part" method="POST" action="add_place.php">
    <h2 id="title" align="center">Новое место</h2>
    <input id="place_id" name="place_id" hidden>
    <p><label>Краткое наименование: <input class="form-input" id="name" name="name" type="text" required/></label></p>
    <p><label>Город: <input class="form-input" id="city" name="city" type="text" required/></label></p>
    <p><label>Улица: <input class="form-input" id="street" name="street" type="text" required/></label></p>
    <p><label>Номер дома: <input class="form-input" id="number" name="number" type="text" required/></label></p>
    <input id="submit-btn" class="submit-btn" type="submit" value="Создать">
</form>

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['place_id']) && $_POST['place_id'] != "") {
        $query =
            "UPDATE place SET
               name = '{$_POST['name']}',
               city = '{$_POST['city']}',
               street = '{$_POST['street']}',
               street_number = '{$_POST['number']}'
            WHERE id = {$_POST['place_id']}";
        $result = $conn->query($query);
        if ($result === true) {
            alert('Изменено');
        } else {
            echo $conn->error;
            alert('Не удалось изменить');
        }
    } else {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $street = $_POST['street'];
        $n = $_POST['number'];
        $query =
            "INSERT INTO place(name, city, street, street_number) 
        VALUES ('$name','$city', '$street', '$n')";
        $result = $conn->query($query);
        if ($result == true) {
            alert('Новая запись добавлена успешно');
        } else {
            alert('Ошибка, добавить запись не удалось');
        }
    }
} elseif (isset($_GET['id'])) {
    $query =
        "SELECT name, city, street, street_number n
        FROM place 
        WHERE id = {$_GET['id']}";
    $result = $conn->query($query);
    if ($result == true) {
        $row = $result->fetch_assoc();
        echo "<script>
                    document.getElementById('title').textContent = 'Изменение информации о месте';
                    document.getElementById('name').value = '{$row['name']}';
                    document.getElementById('city').value = '{$row['city']}';
                    document.getElementById('street').value = '{$row['street']}';
                    document.getElementById('number').value = '{$row['n']}';
                    document.getElementById('place_id').value = '{$_GET['id']}';
                    document.getElementById('submit-btn').value = 'Сохранить';
               </script>";
        $result->free_result();

    } else {
        alert('Не удалось загрузить данные: {$conn->error}');
    }
}

?>