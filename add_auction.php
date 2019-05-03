<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавить аукцион</title>
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
$form->filename = 'add_auction.php';
$form->newTitle = 'Добавить аукцион';
$form->editTitle = 'Изменить информацию об аукционе';
$form->tableName = 'auctions';
$form->fields =
    array(
        array('label' => 'Краткое наименование: ', 'type' => 'text-with-max', 'name' => 'name', 'max' => '60'),
        array('label' => 'Дата аукциона', 'type' => 'date', 'name' => 'date_auc'),
        array('label' => 'Время аукциона', 'type' => 'time', 'name' => 'time_auc'),
        array('label' => 'Место проведения', 'type' => 'selection', 'name' => 'place_id',
            'selection' => array('val' => 'id', 'viewVal' => 'name', 'tableName' => 'places')),
        array('label' => 'Описание: ', 'type' => 'textarea', 'name' => 'description')
    );
$form->initForm();
$form->makeRes();
?>
</body>
</html>
