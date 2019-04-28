<html>
<head>
    <title>Подробная информация</title>
    <link rel="stylesheet" type="text/css" href="css/form-style.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
<?php include_once("menu.php");
include_once('db/db_conn_open.php');
$id = $_GET['id'];
$query =
    "SELECT date_auc, time_auc, pl.name place, auc.description descr
        FROM auctions auc inner join place pl on auc.place_id = pl.id
        WHERE auc.id = {$id}";
$result_auc = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result_auc);
$auc_date = $row['date_auc'];
$auc_time = date_create($row['time_auc']);
$auc_time = date_format($auc_time, "H:i");
$auc_place = $row['place'];
$descr = $row['descr'];
mysqli_free_result($result_auc);
echo "<div class='main-form width-40'>";
echo "<p>{$descr}</p><hr/>";
echo "<p>Дата аукциона: {$auc_date}</p><hr/>";
echo "<p>Время аукциона: {$auc_time}</p><hr/>";
echo "<p>Место: {$auc_place}</p><hr/>";

$query =
    "SELECT description, start_cost from lots where auction_id = ${id}";
$result_lots = mysqli_query($conn, $query) or die(mysqli_error($conn));;
echo "<p>Лоты, выставленные на аукционе:</p>";
echo "<ol>";
while ($row = mysqli_fetch_assoc($result_lots)) {
    echo "<li>{$row['description']} {$row['start_cost']} </li>";
}
echo "</ol>";
echo "</div>";
mysqli_free_result($result_lots);
?>

</body>
</html>
