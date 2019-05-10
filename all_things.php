<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Места проведения аукционов</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/table-style.css" type="text/css">
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <?php include_once("menu.php") ?>
    <?php include_once("db/db_conn_open.php");
    include_once("utils.php") ?>
</head>
<body>

<h3 align="center">Предметы</h3>


<hr/>
<table class="main-table width-60">
    <tr>
        <th class="col-20 centered-text">Наименование предмета</th>
        <th class="col-20 centered-text">Описание</th>
        <th class="col-10">Собственник</th>
        <th class="col-10"></th>
        <th class="col-10"></th>
    </tr>
    <?php
    if (isset($_GET["del"])) {
        $id = $_GET["del"];
        $query = "DELETE FROM things where id={$id}";
        $res = $conn->query($query);
        if ($res == false) {
            alert('Удалить не удалось: скорее всего предмет используется в аукционах');
        }
    }

    $query =
        "SELECT t.id, p.name p_name, description, t.name t_name FROM things t
         INNER JOIN participants p ON t.owner_id=p.id ORDER BY 2";

    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        echo "<tr>";
        echo "<td>{$row['t_name']}</td>";
        echo "<td>{$row['description']}</td>";
        echo "<td>{$row['p_name']}</td>";
        echo "<td><a class='changebtn' href='add_subject.php?id={$row['id']}'>Изменить</a>";
        echo "<td><a class='deletebtn'
                    onclick=\"if(confirm('Вы уверены, что хотите удалить?')){ this.href='all_place.php?del={$id}';}else{return false;}\" 
                    href=''>Удалить</button>
              </td>";
        echo "</tr>";
    }

    $result->free_result();
    //        include_once("db/db_conn_close.php");

    ?>
</table>
</body>
</html>