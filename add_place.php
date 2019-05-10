<html lang="ru">
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
$form->tableName = 'places';
$form->errno1062unic = 'краткое наименование должно быть уникальным';
$form->fields =
    array(
        array('label' => 'Краткое наименование: ', 'type' => 'text-with-max', 'name' => 'name', 'max' => '60'),
        array('label' => 'Город: ', 'type' => 'text-with-max', 'name' => 'city', 'max' => '60'),
        array('label' => 'Улица: ', 'type' => 'text-with-max', 'name' => 'street', 'max' => '60'),
        array('label' => 'Номер дома:', 'type' => 'text-with-max', 'name' => 'number', 'max' => '15'),
    );
$form->initForm();
$form->makeRes();
?>
</body>
</html>
