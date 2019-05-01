<!DOCTYPE html>
<html>
<head>
    <title>Места проведения аукционов</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/table-style.css" type="text/css">
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <?php include_once("menu.php") ?>
    <?php include_once("db/db_conn_open.php");
    include_once("utils.php") ?>
</head>
<body>

<h3 align="center">Места проведения аукционов</h3>


<hr/>
<table class="main-table width-60">
    <tr>
        <th class="col-20 centered-text">Краткое наименование</th>
        <th class="col-20 centered-text">Город</th>
        <th class="col-30 centered-text">Улица</th>
        <th class="col-10">Номер дома</th>
        <th class="col-10"></th>
        <th class="col-10"></th>
    </tr>
    <?php
    if (isset($_GET["del"])) {
        $id = $_GET["del"];
        $query = "DELETE FROM place where id={$id}";
        $res = $conn->query($query);
        if ($res == false) {
            if ($conn->errno == 1451) {
                alert('Удалить не удалось: в этом месте проводятся существующие аукционы');
            } else {
                alert('Удалить не удалось: непредвиденная ошиибка');
            }
        }
    }

    $query =
        "SELECT id, name, city, street, street_number n from place";

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
    //        include_once("db/db_conn_close.php");

    ?>
</table>
</body>
</html>

<?php
//include_once("db/db_conn_open.php");
//include_once("utils.php");
//if (isset($_GET["del"])) {
//    $id = $_GET["del"];
//    $query = "DELETE FROM place where id={$id}";
//    $res = $conn->query($query);
//    if ($res == false) {
//        if ($conn->errno == 1451) {
//            alert('Удалить не удалось: в этом месте проводятся существующие аукционы');
//        } else {
//            alert('Удалить не удалось: непредвиденная ошиибка');
//        }
//    }
//}
//
//?>
