<html lang="ru">
<head>
    <title>Подробная информация</title>
</head>
<body>
<?php include_once("menu.php");
include_once('db/db_conn_open.php');
$id = $_GET['id'];
$date_from = $_GET['dateFrom'];
$date_to = $_GET['dateTo'];
$query =
    "SELECT t.id, p.name p_name, t.description description, t.name t_name FROM things t
         INNER JOIN participants p ON t.owner_id=p.id
        WHERE t.id = {$id}";
$result_auc = $conn->query($query) or die($conn->error);
$row = $result_auc->fetch_assoc();
$name = $row['t_name'];
$descr = $row['description'];
$p_name = $row['p_name'];
$result_auc->free_result();
echo "<div class='main-form width-40'>";
echo "<p>Наименование: $name</p><hr/>";
echo "<p>Описание: $descr</p><hr/>";
echo "<p>Собственник: $p_name</p><hr/>";

$query =
    "SELECT a.id id, a.name name FROM auctions a 
    INNER JOIN lots l on l.auc_id=a.id
    WHERE l.thing_id=$id and date_auc>='$date_from' and date_auc<='$date_to'";

$res = $conn->query($query);
echo "<p>Аукционы, в которых этот предмет участвовал, с $date_from по $date_to:</p>";
echo "<ol>";
while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    echo "<li><a class='simplebtn' href='auction_full.php?id=$id'>{$row['name']}</a></li><br>";
}
echo "</ol>";
echo "</div>";
$res->free_result();
include_once("db/db_conn_close.php");
?>

</body>
</html>
