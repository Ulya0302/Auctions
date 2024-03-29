<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
require_once("utils.php");
include_once("db/db_conn_open.php");
?>
<link rel="stylesheet" href="css/dropdown-menu.css" type="text/css">
<link rel="stylesheet" href="css/form-style.css" type="text/css">
<link rel="stylesheet" href="css/common.css" type="text/css">
<link rel="stylesheet" href="css/table-style.css" type="text/css">

<nav>
    <div class="dropdown">
        <button class="dropbtn">Аукционы</button>
        <div class="dropdown-content">
            <a href="add_auction.php">Добавить аукцион</a>
            <a href="auctions_stat.php">Статистика по продажам аукционов</a>
            <a href="auction_chronology.php">Хронология аукционов</a>
            <a href="auc_place_stat.php">Аукционы по месту</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn">Участники</button>
        <div class="dropdown-content">
            <a href="add_participant.php">Добавить нового участника</a>
            <a href="seller_profit_chronology.php">Статистика по доходам продавцов</a>
            <a href="seller_activity.php">Статистика по активности продавцов</a>
            <a href="buyer_stat.php">Статистика по покупателям</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn">Лоты</button>
        <div class="dropdown-content">
            <a href="add_lot.php">Добавить новый лот</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn">Предметы</button>
        <div class="dropdown-content">
            <a href="add_subject.php">Добавить предмет</a>
            <a href="all_things.php">Показать все предметы</a>
            <a href="thing_stat.php">Показать проданные предметы</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn">Места</button>
        <div class="dropdown-content">
            <a href="add_place.php">Добавить место</a>
            <a href="all_place.php">Показать текущие места</a>
        </div>
    </div>
    <div style="float: right">
        <a href="logout.php" class="simplebtn">Выйти</a>
    </div>
</nav>
<?php echo "<span style='float: right;'>Добро пожаловать, {$_SESSION['user']}</span><br>"; ?>
<hr/>


