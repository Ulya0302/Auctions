<html>
<head>
    <meta charset="utf-8">
    <title>Добавить участника</title>
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
$form->filename = 'add_participant.php';
$form->newTitle = 'Добавить участника';
$form->editTitle = 'Изменить информацию об участнике';
$form->tableName = 'participants';
$form->errno1062unic = 'краткое наименование, номер телефона и email должны быть уникальными';
$form->fields =
    array(
        array('label' => 'Краткое наименование: ', 'type' => 'text', 'name' => 'name'),
        array('label' => 'Телефон: ', 'type' => 'tel', 'name' => 'phone'),
        array('label' => 'Email: ', 'type' => 'email', 'name' => 'email'),
    );
$form->initForm();
$form->makeRes();
?>
</body>
</html>