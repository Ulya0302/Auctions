<html lang="ru">
<head>
    <title>Подробная информация</title>
</head>
<body>
<?php
include_once("menu.php");
$auc_id = $_GET['id'];
$query =
    "SELECT date_auc, time_auc, pl.name place, auc.description descr
        FROM auctions auc 
        inner join places pl on auc.place_id = pl.id
        WHERE auc.id = {$auc_id}";
$result_auc = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = $result_auc->fetch_assoc();
$auc_date = $row['date_auc'];
$auc_time = convert_time($row['time_auc']);
$auc_place = $row['place'];
$descr = $row['descr'];
$result_auc->free_result();
echo "<div class='main-form width-40'>";
echo "<p>{$descr}</p><hr/>";
echo "<p>Дата аукциона: {$auc_date}</p><hr/>";
echo "<p>Время аукциона: {$auc_time}</p><hr/>";
echo "<p>Место: {$auc_place}</p><hr/>";

$query =
    "SELECT lots.id id, name, start_cost from lots 
    inner join things s on s.id = lots.thing_id
    where auc_id = ${auc_id}";
$result_lots = $conn->query($query);
echo "<p>Лоты, выставленные на аукционе:</p>";
echo "<ol>";
while ($row = $result_lots->fetch_assoc()) {
    $t_name = $row['name'];
    echo "<li>$t_name<br>Стартовая цена: {$row['start_cost']}<br>";
    $query =
        "SELECT final_cost f, pr.name name FROM purchases p 
            INNER JOIN lots l on l.id=p.lot_id
            INNER JOIN things t ON t.id=l.thing_id
            INNER JOIN participants pr ON pr.id=t.owner_id
            WHERE lot_id={$row['id']}";
    $res_lot = $conn->query($query);
    $query =
        "SELECT pr.name name FROM purchases p 
         INNER JOIN lots l on l.id=p.lot_id 
         INNER JOIN participants pr ON pr.id=p.buyer_id
         WHERE lot_id={$row['id']}";
    $res_buy = $conn->query($query);
    echo $conn->error;
    if ($row_q = $res_lot->fetch_assoc()) {
        $row_an = $res_buy->fetch_assoc();
        echo "<span style='color: #000000; background-color: #00ff96'>Лот продан. </span>
               <span style='background-color: rgba(120,255,201,0.66);'>
                <br> Финальная цена: " . $row_q['f'] . "
                <br> Продавец: " . $row_q['name'] . "
                <br> Покупатель: " . $row_an['name'] . "</span>";
    } else {
        echo "<a class='simplebtn'
                href='add_purchase.php?auc_id={$auc_id}&lot_id={$row['id']}'>Добавить факт продажи</a>";
    }
    $res_buy->free_result();
    $res_lot->free_result();
    echo "</li><br>";

}
echo "</ol>";
echo "</div>";
$result_lots->free_result();
include_once("db/db_conn_close.php");
?>
</body>
</html>
