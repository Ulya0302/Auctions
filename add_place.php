<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавить место</title>
    <?php require_once('AddForm.php') ?>
</head>
<body>
<?php
include_once('menu.php');
$form = new AddForm();
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
include_once("db/db_conn_close.php");
?>
</body>
</html>
