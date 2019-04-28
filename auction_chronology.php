<?php
function create_table($conn)
{
    $date_from = $_GET['fromDate'];
    $date_to = $_GET['toDate'];
    echo "<hr/><h3>Статистика аукционов с {$date_from} по {$date_to}</h3><hr/>";
    echo '
    <table class="main-table width-60" >
    <tr style="height: 40px">
        <th >Об аукционе</th>
        <th class="col-25">Место проведения</th>
        <th class="col-10">Дата проведения</th>
        <th class="col-10" ">Время проведения</th>
        <th class="col-10"></th>
    </tr>';
    $query =
        "SELECT auc.id id, date_auc, time_auc, pl.name place, auc.description descr
        FROM auctions auc inner join place pl on auc.place_id = pl.id
        WHERE date_auc >= '{$date_from}' and date_auc <= '{$date_to}'
        ORDER BY date_auc ASC";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $time_auc = convert_time($row['time_auc']);
        echo "<tr>";
        echo "<td>{$row['descr']}</td>";
        echo "<td>{$row['place']}</td>";
        echo "<td>{$row['date_auc']}</td>";
        echo "<td>{$time_auc}</td>";
        echo "<td><a class='changebtn' href='auction_full.php?id={$id}'>Подробнее</a>";
        echo "</tr>";
    }

    echo "</table>";

    mysqli_free_result($result);

    //        include_once("db/db_conn_close.php");


}

?>
<html>
<head>
    <meta charset="utf-8">
    <title>Хронология аукционов</title>
    <link type="text/css" href="css/form-style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/table-style.css" type="text/css">
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <?php include_once("db/db_conn_open.php");
    include_once("utils.php")?>

</head>
<body onload="setData()">
<?php include_once("menu.php") ?>
<form class="main-form width-40"  method="GET" action="auction_chronology.php">
    <p><label>С даты: <input placeholder="С даты" id="fromDate" class="form-input" name="fromDate" type="date"
                             required/></label></p>
    <p><label>По дату: <input placeholder="По дату" id="toDate" class="form-input" name="toDate" type="date" required/></label>
    </p>
    <input class="submit-btn" type="submit" value="Получить">
</form>
<?php
if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
    create_table($conn);
}

?>
<script type="text/javascript">
    function setData() {
        if (get("fromDate")) {
            document.getElementById("fromDate").value = get("fromDate");
            document.getElementById("toDate").value = get("toDate");
        }
    }

    function get(name) {
        name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search);
        if (name)
            return decodeURIComponent(name[1]);
    }
</script>
</body>
</html>