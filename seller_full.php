<html lang="ru">
<head>
    <title>Подробная информация</title>
</head>
<body>
<?php
include_once("menu.php");
$id = $_GET['id'];
$date_from = $_GET['dateFrom'];
$date_to = $_GET['dateTo'];
$query =
    "SELECT name, email, phone
        FROM participants p
        WHERE p.id = {$id}";
$result_auc = mysqli_query($conn, $query) or die(mysqli_error($conn));
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
    "SELECT DISTINCT s.name name from things s 
    inner join lots on s.id = lots.thing_id
    inner join auctions a on a.id=lots.auc_id
    where s.id = $id and date_auc>='$date_from' and date_auc<='$date_to'";
$res = $conn->query($query);
echo "<p>Предметы, выставленные на аукционах с $date_from по $date_to:</p>";
echo "<ol>";
while ($row = $res->fetch_assoc()) {
    echo "<li>{$row['name']}<br></li";
}
echo "</ol>";
echo "</div>";
$res->free_result();
?>
</body>
</html>
