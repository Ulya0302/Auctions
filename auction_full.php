<html lang="ru">
<head>
    <title>Подробная информация</title>
    <link rel="stylesheet" type="text/css" href="css/form-style.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
<?php include_once("menu.php");
include_once('db/db_conn_open.php');
include_once('utils.php');
$id = $_GET['id'];
$query =
    "SELECT date_auc, time_auc, pl.name place, auc.description descr
        FROM auctions auc 
        inner join places pl on auc.place_id = pl.id
        WHERE auc.id = {$id}";
$result_auc = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = $result_auc->fetch_assoc();
$auc_date = $row['date_auc'];
$auc_time = convert_time($row['time_auc']);
$auc_place = $row['place'];
$descr = $row['descr'];
mysqli_free_result($result_auc);
echo "<div class='main-form width-40'>";
echo "<p>{$descr}</p><hr/>";
echo "<p>Дата аукциона: {$auc_date}</p><hr/>";
echo "<p>Время аукциона: {$auc_time}</p><hr/>";
echo "<p>Место: {$auc_place}</p><hr/>";

$query =
    "SELECT s.name name, start_cost from lots 
    inner join things s on s.id = lots.thing_id
    where auc_id = ${id}";
$result_lots = mysqli_query($conn, $query) or die(mysqli_error($conn));;
echo "<p>Лоты, выставленные на аукционе:</p>";
echo "<ol>";
while ($row = $result_lots->fetch_assoc()) {
    echo "<li>{$row['name']}<br>Стартовая цена: {$row['start_cost']}</li><br>";
}
echo "</ol>";
echo "</div>";
$result_lots->free_result();
?>

</body>
</html>
