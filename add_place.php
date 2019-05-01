<html>
<head>
    <meta charset="utf-8">
    <title>Добавить место</title>
    <link type="text/css" href="css/form-style.css" rel="stylesheet">
    <link type="text/css" href="css/common.css" rel="stylesheet">
    <?php include_once("db/db_conn_open.php"); ?>
    <?php include_once("utils.php");
    include_once('AddForm.php')
    ?>

</head>
<body>
<?php
global $form;
include_once('menu.php');
$form = new AddForm();
$form->filename = 'add_place.php';
$form->newTitle = 'Добавить место';
$form->editTitle = 'Изменить информацию о месте';
$form->tableName = 'place';
$form->errno1062unic = 'краткое наименование должно быть уникальным';
$form->fields =
    array(
        array('label' => 'Краткое наименование', 'type' => 'text', 'name' => 'name'),
        array('label' => 'Город', 'type' => 'text', 'name' => 'city'),
        array('label' => 'Улица', 'type' => 'text', 'name' => 'street'),
        array('label' => 'Номер дома', 'type' => 'text', 'name' => 'street_number'),
    );
$form->initForm();
$form->makeRes();
?>
</body>
</html>
