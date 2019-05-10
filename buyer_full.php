<html lang="ru">
<head>
    <title>Подробная информация</title>
    <link rel="stylesheet" type="text/css" href="css/form-style.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
<?php include_once("menu.php");
include_once('db/db_conn_open.php');
$id = $_GET['id'];
$date_from = $_GET['dateFrom'];
$date_to = $_GET['dateTo'];
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
    echo "<li><a class='simplebtn' href='auction_full.php?id=$id'>{$row['name']}</a><br></li";
}
echo "</ol>";
echo "</div>";
$res->free_result();
?>

</body>
</html>
