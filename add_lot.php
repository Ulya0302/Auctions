<html>
<head>
    <meta charset="utf-8">
    <title>Добавить лот</title>
    <link type="text/css" href="css/form-style.css" rel="stylesheet">
    <link type="text/css" href="css/common.css" rel="stylesheet">
    <?php include_once("db/db_conn_open.php"); ?>
    <?php include_once("utils.php");
    include_once ('AddForm.php')
    ?>

</head>
<body>
<?php
global $form;
include_once ('menu.php');
$form = new AddForm();
$form->filename = 'add_lot.php';
$form->newTitle = 'Добавить лот';
$form->editTitle = 'Изменить информацию о лоте';
$form->tableName = 'lots';
$form->errno1062unic = 'Лот с таким номером или такой предмет уже существует на данном аукционе';
$form->fields =
    array(
        array('label' => 'Аукцион: ', 'type' => 'selection', 'name' => 'auction_id',
            'selection' => array('val' => 'id', 'viewVal' => 'description', 'tableName' => 'auctions')),
        array('label' => 'Предмет: ', 'type' => 'selection', 'name' => 'subject_id',
            'selection' => array('val' => 'id', 'viewVal' => 'name', 'tableName' => 'subjects')),
        array('label' => 'Номер лота: ', 'type' => 'number', 'name' => 'lot_number'),
        array('label' => 'Стартовая цена: ', 'type' => 'number', 'name' => 'start_cost')
    );
$form->initForm();
$form->makeRes();
if (isset($_GET['id'])) {
    echo "<script>
           document.getElementById('auction_id').disabled = true;
           document.getElementById('subject_id').disabled = true;
           </script>";

}
?>
</body>
</html>
