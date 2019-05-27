<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавить предмет</title>
    <?php require_once('AddForm.php') ?>
</head>
<body>
<?php
include_once ('menu.php');
$form = new AddForm();
$form->newTitle = 'Добавить предмет';
$form->editTitle = 'Изменить информацию о предмете';
$form->tableName = 'things';
$form->errno1062unic = 'Имя должно быть уникальным';
$form->fields =
    array(
        array('label' => 'Краткое наименование: ', 'type' => 'text-with-max', 'name' => 'name', 'max' => '60'),
        array('label' => 'Продавец: ', 'type' => 'selection', 'name' => 'owner_id',
            'selection' => array('val' => 'id', 'viewVal' => 'name', 'tableName' => 'participants')),
        array('label' => 'Описание: ', 'type' => 'textarea', 'name' => 'description')
    );
$form->initForm();
$form->makeRes();
include_once("db/db_conn_close.php");
?>
</body>
</html>
