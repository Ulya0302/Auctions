<html lang="ru">
<head>
    <title>Подробная информация</title>
</head>
<body>
<?php include_once("menu.php");
$id = $_GET['id'];
if (!is_numeric($id)) {
    error("Ошибка");
    exit();
}
$date_from = $_GET['dateFrom'];
if (check_datetime($date_from) == false) {
    error("Ошибка");
    exit();
}
$date_to = $_GET['dateTo'];
if (check_datetime($date_to) == false) {
    error("Ошибка");
    exit();
}
$query =
    "SELECT name, email, phone
        FROM participants p
        WHERE p.id = {$id}";
$result_auc = $conn->query($query) or die($conn->error);
$row = $result_auc->fetch_assoc();
$name = $row['name'];
$email = $row['email'];
$phone = $row['phone'];
$result_auc->free_result();
echo "<div class='main-form width-40'>";
echo "<p>Продавец: $name</p><hr/>";
echo "<p>Телефон: $phone</p><hr/>";
echo "<p>E-mail: $email</p><hr/>";

$query =
    "SELECT a.id id, a.name name FROM auctions a 
    INNER JOIN lots l on l.auc_id=a.id
    INNER JOIN purchases p on l.id=p.lot_id
    WHERE p.buyer_id=$id and date_auc>='$date_from' and date_auc<='$date_to'";

$res = $conn->query($query);
echo "<p>Аукционы, в которых покупал предметы с $date_from по $date_to:</p>";
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
