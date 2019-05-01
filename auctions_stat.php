<?php
include_once("db/db_conn_open.php");
include_once("utils.php");
if (isset($_GET["del"])) {
    $id = $_GET["del"];
    $query = "DELETE FROM auctions where id={$id}";
    $result = $conn->query($query);
    if ($result == false) {
        alert('Удалить не удалось: {$conn->error}');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Статистика по продажам</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/table-style.css" type="text/css">
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <?php include_once("menu.php") ?>
    <?php include_once("db/db_conn_open.php");
    include_once("utils.php") ?>
</head>
<body>

<h3 align="center">Статистика по продажам на аукционах</h3>


<hr/>
<table class="main-table width-85">
    <tr>
        <th class="col-10 centered-text">Дата проведения</th>
        <th class="col-5 centered-text">Время проведения</th>
        <th class="col-15 centered-text">Место проведения</th>
        <th>Описание</th>
        <th class="col-10 centered-text">Сумма проданных лотов</th>
        <th class="col-10"></th>
        <th class="col-10"></th>
        <th class="col-10"></th>
    </tr>
    <?php

    $query =
        "SELECT auc.id id, date_auc, time_auc, pl.name place, auc.description descr, sum(start_cost) sum_c 
        FROM auctions auc left join lots on auc.id=lots.auction_id 
            left join purchases p on lots.id = p.lot_id 
            inner  join place pl on auc.place_id = pl.id
        GROUP BY auc.id order by sum_c DESC";

    $result = $conn->query($query);
    /* Выборка результатов запроса */
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $auc_time = convert_time($row['time_auc']);
        echo "<tr>";
        echo "<td>{$row['date_auc']}</td>";
        echo "<td>{$auc_time}</td>";
        echo "<td>{$row['place']}</td>";
        echo "<td>{$row['descr']}</td>";
        echo "<td>{$row['sum_c']}</td>";
        echo "<td><a class='changebtn' href='auction_full.php?id={$id}'>Подробнее</a>";
        echo "<td><a class='changebtn' href='add_auction.php?id={$row['id']}'>Изменить</a>";
        echo "<td><a class='deletebtn'
                    onclick=\"if(confirm('Вы уверены, что хотите удалить?')){ this.href='auctions_stat.php?del={$id}';}else{return false;}\" 
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
