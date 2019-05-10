<?php
function create_table($conn)
{
    $date_from = $_GET['fromDate'];
    $date_to = $_GET['toDate'];
    echo "<hr/><h3 align='center'>Участвующие в аукционах продавцы с {$date_from} по {$date_to}</h3><hr/>";
    echo '
    <table class="main-table width-60">
    <tr style="height: 40px">
        <th>Участник</th>
        <th>Телефон</th>
        <th>Email</th>
        <th class="col-10"></th>
    </tr>';
    $query =
        "SELECT p.id id, p.name name, phone, email
            FROM participants p
            left join things s on s.owner_id = p.id
            left join lots l on l.thing_id = s.id
            left JOIN auctions a on l.auc_id = a.id
            where a.date_auc >= '{$date_from}' and a.date_auc <= '{$date_to}'
            GROUP BY p.name
            HAVING count(l.id) > 0
";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        echo "<tr>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['phone']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td><a class='changebtn' href='seller_full.php?id={$id}&dateFrom=$date_from&dateTo=$date_to'>Подробнее</a>";
        echo "</tr>";
    }

    echo "</table>";

    $result->free_result();

    //        include_once("db/db_conn_close.php");


}

?>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Хронология аукционов</title>
    <link type="text/css" href="css/form-style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/table-style.css" type="text/css">
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <?php include_once("db/db_conn_open.php");
    include_once("utils.php") ?>

</head>
<body onload="setData()">
<?php include_once("menu.php") ?>
<form class="main-form width-40" method="GET" action="seller_activity.php">
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