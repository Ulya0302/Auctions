<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Места проведения аукционов</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
include_once("menu.php");
if (isset($_GET["del"])) {
    $id = $_GET["del"];
    $query = "DELETE FROM places where id={$id}";
    $res = $conn->query($query);
    if ($res == false) {
        if ($conn->errno == 1451) {
            error('Удалить не удалось: в этом месте проводятся аукционы');
        } else {
            error('Удалить не удалось: непредвиденная ошиибка');
        }
    }
}
?>

<h3 align="center">Места проведения аукционов</h3>
<hr/>
<table class="main-table width-60">
    <tr>
        <th class="col-20 centered-text">Краткое наименование</th>
        <th class="col-20 centered-text">Город</th>
        <th class="col-20 centered-text">Улица</th>
        <th class="col-10">Номер дома</th>
        <th class="col-10"></th>
        <th class="col-10"></th>
    </tr>
    <?php


    $query =
        "SELECT id, name, city, street, number n from places";

    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        echo "<tr>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['city']}</td>";
        echo "<td>{$row['street']}</td>";
        echo "<td>{$row['n']}</td>";
        echo "<td><a class='changebtn' href='add_place.php?id={$row['id']}'>Изменить</a>";
        echo "<td><a class='deletebtn'
                    onclick=\"if(confirm('Вы уверены, что хотите удалить?')){ this.href='all_place.php?del={$id}';}else{return false;}\" 
                    href=''>Удалить</button>
              </td>";
        echo "</tr>";
    }

    $result->free_result();
    include_once("db/db_conn_close.php");
    ?>
</table>
</body>
</html>