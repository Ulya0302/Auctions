<?php
function create_table($conn)
{
    echo '
    <table class="main-table width-60" >
    <tr>
        <th >Об аукционе</th>
        <th>Краткое название</th>
        <th class="col-20">Место проведения</th>
        <th class="col-10">Дата проведения</th>
        <th class="col-10">Время проведения</th>
        <th class="col-10">Число лотов</th>
        <th>Посмотреть лоты</th>
    </tr>';
    $query =
        "SELECT auc.id id, auc.name name, date_auc, time_auc, pl.name place, auc.description descr, count(lots.id) auc_c
        FROM auctions auc inner join places pl on auc.place_id = pl.id left join lots on lots.auc_id = auc.id
        WHERE pl.id = {$_GET['place']}
        GROUP BY auc.id
        ORDER BY auc_c DESC ";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    echo "<hr/><h3>Статистика аукционов по месту</h3><hr/>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $time_auc = convert_time($row['time_auc']);
        echo "<tr>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['place']}</td>";
        echo "<td>{$row['descr']}</td>";
        echo "<td>{$row['date_auc']}</td>";
        echo "<td>{$time_auc}</td>";
        echo "<td>{$row['auc_c']}</td>";
        echo "<td><a class='changebtn' href='auction_full.php?id={$id}'>Подробная информация</a>";
        echo "</tr>";
    }
    echo "</table>";

    $result->free_result();
    include_once("db/db_conn_close.php");


}

?>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Хронология аукционов</title>
</head>
<body onload="setData()">
<?php include_once("menu.php") ?>
<form class="main-form width-40" method="GET" action="auc_place_stat.php">
    <p><label>
            Место проведения:
            <select id="place" name="place">
                <?php
                $query = "SELECT id, name FROM places";
                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
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
    <input class="submit-btn" type="submit" value="Получить">
</form>
<?php
if (isset($_GET['place'])) {
    create_table($conn);
}
include_once("db/db_conn_close.php");
?>
<script type="text/javascript">
    function setData() {
        if (get("place")) {
            document.getElementById("place").value = get("place");
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