<html>
<head>
    <meta charset="utf-8">
    <title>Добавить аукцион</title>
    <link type="text/css" href="css/form-style.css" rel="stylesheet">
    <link type="text/css" href="css/common.css" rel="stylesheet">
    <?php include_once("db/db_conn_open.php"); ?>
    <?php include_once("utils.php"); ?>
</head>
<body>
<?php include_once("menu.php") ?>
<form class="main-form width-40" id="new_auc" method="POST" action="add_auction.php">
    <h2 align="center" id="title">Новый аукцион</h2>
    <input id="auc_id" name="auc_id" hidden>
    <p><label>Дата аукциона:<input class="form-input" id="date" name="date" type="date"/></label></p>
    <p><label>Время аукциона:<input class="form-input" id="time" name="time" type="time"/></label></p>
    <p><label>
            Место проведения:
            <select id="place" name="place">
                <?php
                $query = "SELECT id, name FROM place";
                $result = $conn->query($query);

//                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                while ($row = mysqli_fetch_assoc($result)) {
                    $cur_id = $row['id'];
                    $cur_name = $row['name'];
                    echo "<option value='$cur_id'>$cur_name</option>";
                }
                mysqli_free_result($result);
                ?>
            </select>
        </label>
    </p>
    <p><label>Описание: <textarea placeholder="Специфика аукциона" id="descr" name="description"></textarea></label></p>
    <input id="submit-btn" class="submit-btn" type="submit" value="Создать">
</form>

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['auc_id']) && $_POST['auc_id'] != "") {
        $query =
            "UPDATE auctions SET 
               date_auc = '{$_POST['date']}',
               time_auc = '{$_POST['time']}',
               place_id = {$_POST['place']},
               description = '{$_POST['description']}'
            WHERE id = {$_POST['auc_id']}";
        $result = $conn->query($query);
        if ($result === true) {
            alert('Изменено!');
        } else {
            echo $conn->error;
            alert('Не удалось изменить');
        }
    } else {
        $date_auc = $_POST['date'];
        $time_auc = $_POST['time'];
        $place_id = $_POST['place'];
        $descr = $_POST['description'];
        $query =
            "INSERT INTO auctions(date_auc, time_auc, place_id, description) 
        VALUES ('$date_auc','$time_auc', $place_id, '$descr')";
        $result = $conn->query($query);
        if ($result === TRUE) {
            alert('Новая запись добавлена успешно');
        } else {
            alert('Ошибка, добавить запись не удалось');
        }
    }
}
 elseif (isset($_GET['id'])) {
    $query =
        "SELECT date_auc, time_auc, place_id, description descr
        FROM auctions 
        WHERE id = {$_GET['id']}";
    $result = $conn->query($query);
    if ($result == true) {
        $row = $result->fetch_assoc();
        $time = convert_time($row['time_auc']);
        echo "<script>
                    document.getElementById('title').textContent = 'Изменение аукциона';
                    document.getElementById('date').value = '{$row['date_auc']}';
                    document.getElementById('time').value = '{$time}';
                    document.getElementById('place').value = {$row['place_id']};
                    document.getElementById('descr').value = '{$row['descr']}';
                    document.getElementById('auc_id').value = '{$_GET['id']}';
                    document.getElementById('submit-btn').value = 'Сохранить';
               </script>";
        $result->free_result();

    } else {
        alert('Не удалось загрузить данные');
    }
}

?>