<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавить участника</title>
    <?php require_once('AddForm.php') ?>
</head>
<body>
<?php
include_once('menu.php');
$form = new AddForm();
$form->newTitle = 'Добавить участника';
$form->editTitle = 'Изменить информацию об участнике';
$form->tableName = 'participants';
$form->errno1062unic = 'краткое наименование, номер телефона и email должны быть уникальными';
$form->fields =
    array(
        array('label' => 'Краткое наименование: ', 'type' => 'text-with-max', 'name' => 'name', 'max' => '60'),
        array('label' => 'Телефон: ', 'type' => 'tel', 'name' => 'phone',
            'placeholder' => '10 цифр, начиная с +7', 'pattern' => '\+7[0-9]{10}'),
        array('label' => 'Email: ', 'type' => 'email', 'name' => 'email'),
    );
$form->initForm();
$form->makeRes();
include_once("db/db_conn_close.php");
?>
</body>
</html>