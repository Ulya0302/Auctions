<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/form-style.css">
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <title>Покупки</title>
    <?php
    include_once('menu.php');
    include_once('utils.php');
    include_once('db/db_conn_open.php');
    include_once('AddForm.php'); ?>
</head>
<body>
<?php
if (isset($_GET['error'])) {
    error("Добавить не удалось: {$_GET['message']}");
}
echo '<form class="main-form width-60" id="new_item" method="POST" action="add_purchase.php">';
echo '<h2 align="center">Добавить факт продажи</h2>';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $addForm = new AddForm();
    $query = "SELECT name FROM auctions WHERE id=" . $_GET['auc_id'];
    $res = $conn->query($query);
    $row = $res->fetch_assoc();
    $res->free_result();
    echo "<p><label>Аукцион: <input id='auc_name' name='auc_name' value='{$row['name']}' class='form-input' readonly></label></p>";
    $query = "SELECT lot_number, name FROM lots l 
                INNER JOIN things t on l.thing_id = t.id
                WHERE l.id=" . $_GET['lot_id'];
    $res = $conn->query($query);
    $row = $res->fetch_assoc();
    $res->free_result();
    echo "<p><label>Номер лота: <input class='form-input' id='lot_number' name='lot_number' value='{$row['lot_number']}' readonly></label></p>";
    echo "<p><label>Наименование предмета: <input class='form-input' value='{$row['name']}' readonly></label></p>";
    echo '<p><label>Покупатель: ';
    $addForm->generateSelection('buyer_id', 'id', 'name', 'participants');
    echo '</label></p>';
    echo '<p><label>Финальная цена: <input class="form-input" id="final_cost" name="final_cost"></label></p>';
    echo '<input id="submit-btn" class="submit-btn" type="submit" value="Создать">';
    echo '</form>';
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auc_name = $_POST['auc_name'];
    $lot_number = $_POST['lot_number'];
    $buyer_id = $_POST['buyer_id'];
    $final_cost = $_POST['final_cost'];
    $query = "SELECT id FROM auctions WHERE name = '{$auc_name}'";
    $auc_id = $conn->query($query)->fetch_assoc()['id'];
    $query = "SELECT id FROM lots WHERE lot_number = '$lot_number' and auc_id = $auc_id";
    $lot_id = $conn->query($query)->fetch_assoc()['id'];
    $query =
        "INSERT INTO purchases(lot_id, final_cost, buyer_id) 
            values ($lot_id, $final_cost, $buyer_id)";
    $res = $conn->query($query);
    echo $conn->error;
    if ($res) {
        header("Location: auction_full.php?id={$auc_id}");
    } else {
        header("Location: add_purchase.php?auc_id={$auc_id}&lot_id={$lot_id}&error=true&message={$conn->error}");
    }

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
