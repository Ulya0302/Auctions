<?php


class AddForm
{
    public $fields; // [[nameDB, type, label, selection(val, viewval, tableName)][]]
    public $filename;
    public $tableName;
    public $nameForm;
    public $newTitle;
    public $editTitle;

    function initForm()
    {
        echo '<form class="main-form width-40" id="new_item" method="POST" action="' . $this->filename . '">';
        echo '<h2 align="center" id="title">' . $this->newTitle . '</h2>';
        echo '<input id="id" name="id" hidden>';
        foreach ($this->fields as $field) {
            if ($field['type'] == 'selection') {
                echo '<p><label>' . $field['label'];
                $this->generateSelection(
                    $field['name'],
                    $field['selection']['val'],
                    $field['selection']['viewVal'],
                    $field['selection']['tableName']
                );
                echo '</p></label>';
            } elseif ($field['type'] == 'textarea') {
                echo '<p><label>' . $field['label'] .
                    '<textarea id="' . $field['name'] . '" name="' . $field['name'] . '"></textarea></label></p>';
            } else {
                echo '<p><label>' . $field['label'] .
                    '<input class="form-input" id="' . $field['name'] .
                    '" name="'.$field['name'].'" type="' . $field['type'] . '"/></label></p>';
            }
        }
        echo '<input id="submit-btn" class="submit-btn" type="submit" value="Создать">';
        echo '</form>';

    }

    private function generateSelection($name, $val, $viewVal, $nameTable)
    {
        echo '<select id="' . $name . '" name="' . $name . '">';
        global $conn;
        include('db/db_conn_open.php');
        $query = "SELECT $val, $viewVal FROM $nameTable";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $cur_id = $row[$val];
            $cur_name = $row[$viewVal];
            echo "<option value='$cur_id'>$cur_name</option>";
        }
        echo '</select>';
        $result->free_result();
    }

    function makeRes()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id']) && $_POST['id'] != "") {
                $this->update($_POST['id']);
            } else {
                $this->create();
            }
        } elseif (isset($_GET['id'])) {
            $this->changeOnEdit($_GET['id']);
        }
    }

    function create() {
        global $conn;
        include_once('db/db_conn_open.php');
        include_once('utils.php');
        $cols = array();
        $col_values = array();
        foreach ($this->fields as $val) {
            array_push($cols, $val['name']);
            array_push($col_values, $_POST[$val['name']]);
        }
        $cols = join($cols, ", ");
        $col_values = join($col_values, "', '");

        $query =
            "INSERT INTO ".$this->tableName."($cols)
        VALUES ('$col_values')";
        $result = $conn->query($query);
        if ($result === TRUE) {
            alert('Новая запись добавлена успешно');
        } else {
            alert('Ошибка, добавить запись не удалось');
        }
    }

    function update($id) {
        global $conn;
        include_once('db/db_conn_open.php');
        include_once('utils.php');
        $cols = array();
        foreach ($this->fields as $val) {
            array_push($cols, $val['name'].' = '.$_POST[$val['name']]);
        }
        $cols = join(", ", $cols);
        $query =
            "UPDATE ".$this->tableName." SET $cols WHERE id = $id" ;
        echo $query;
        $result = $conn->query($query);
        if ($result === true) {
            alert('Изменено!');
        } else {
            echo $conn->error;
            alert('Не удалось изменить');
        }
    }

    function changeOnEdit($id)
    {
        $cols = array();
        foreach ($this->fields as $val) {
            array_push($cols, $val['name']);
        }
        global $conn;
        include_once('db/db_conn_open.php');
        include_once('utils.php');
        $cols = join(", ", $cols);
        $query = "SELECT $cols FROM " . $this->tableName . " WHERE id = $id";
        $res = $conn->query($query);
        if ($res == true) {
            $row = $res->fetch_assoc();
            echo "<script>
                    document.getElementById('title').textContent = '" . $this->editTitle . "';
                    document.getElementById('auc_id').value = '$id';
                    document.getElementById('submit-btn').value = 'Сохранить';
                  </script>";
            foreach ($this->fields as $val) {
                if ($val['type'] == 'time') {
                    $time = convert_time($row[$val['name']]);
                    echo "<script>document.getElementById('" . $val['name'] . "').value = '" . $time . "'</script>";

                } else {
                    echo "<script>document.getElementById('" . $val['name'] . "').value = '" . $row[$val['name']] . "'</script>";
                }
            }
        } else {
            alert('Не удалось загрузить данные');
        }

    }
}