<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавить лот</title>
    <?php require_once('AddForm.php') ?>
</head>
<body>
<?php
include_once('menu.php');
$form = new AddForm();
$form->newTitle = 'Добавить лот';
$form->editTitle = 'Изменить информацию о лоте';
$form->tableName = 'lots';
$form->errno1062unic = 'Лот с таким номером или такой предмет уже существует на данном аукционе';
$form->disabled_cols = ['auction_id', 'subject_id'];
$form->fields =
    array(
        array('label' => 'Аукцион: ', 'type' => 'selection', 'name' => 'auc_id',
            'selection' => array('val' => 'id', 'viewVal' => 'name', 'tableName' => 'auctions')),
        array('label' => 'Предмет: ', 'type' => 'selection', 'name' => 'thing_id',
            'selection' => array('val' => 'id', 'viewVal' => 'name', 'tableName' => 'things')),
        array('label' => 'Номер лота: ', 'type' => 'number', 'name' => 'lot_number', 'max' => '9999999999'),
        array('label' => 'Стартовая цена: ', 'type' => 'number', 'name' => 'start_cost', 'max' => '999999999999999999')
    );
$form->initForm();
$form->makeRes();
include_once("db/db_conn_close.php");
?>
</body>
</html>
