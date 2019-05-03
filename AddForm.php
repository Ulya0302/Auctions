<?php


class AddForm
{
    public $fields; // [[nameDB, type, label, selection(val, viewVal, tableName)][]]
    public $filename;
    public $tableName;
    public $nameForm;
    public $newTitle;
    public $editTitle;
    public $errno1062unic;
    public $disabled_cols;

    function initForm()
    {
        echo '<form class="main-form width-40" id="new_item" method="POST" action="' . $this->filename . '">';
        echo '<h2 align="center" id="title">' . $this->newTitle . '</h2>';
        echo '<input id="id" name="id" hidden>';
        foreach ($this->fields as $field) {
            switch ($field['type']) {
                case 'selection':
                    echo '<p><label>' . $field['label'];
                    $this->generateSelection(
                        $field['name'],
                        $field['selection']['val'],
                        $field['selection']['viewVal'],
                        $field['selection']['tableName']
                    );
                    echo '</p></label>';
                    break;
                case 'textarea':
                    echo '<p><label>' . $field['label'] .
                        '<textarea id="' . $field['name'] . '" name="' . $field['name'] . '" required></textarea>
                        </label></p>';
                    break;
                case 'tel':
                    echo '<p><label>' . $field['label'] .
                        '<input pattern="' . $field['pattern'] . '" 
                        placeholder="' . $field['placeholder'] . '" class="form-input" 
                        id="' . $field['name'] .
                        '" name="' . $field['name'] . '" type="' . $field['type'] . '" required/>
                        </label></p>';
                    break;
                case 'number':
                    echo '<p><label>' . $field['label'] .
                        '<input max="' . $field['max'] . '" class="form-input" id="' . $field['name'] .
                        '" name="' . $field['name'] . '" type="' . $field['type'] . '" required/></label></p>';
                    break;
                case 'text-with-max':
                    echo '<p><label>' . $field['label'] .
                        '<input placeholder="Максимальная длина: ' . $field['max'] . '" maxlength="' . $field['max'] . '" class="form-input" id="' . $field['name'] .
                        '" name="' . $field['name'] . '" type="' . $field['type'] . '" required/></label></p>';
                    break;
                default:
                    echo '<p><label>' . $field['label'] .
                        '<input class="form-input" id="' . $field['name'] .
                        '" name="' . $field['name'] . '" type="' . $field['type'] . '" required/></label></p>';

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

    function create()
    {
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
            "INSERT INTO " . $this->tableName . "($cols)
        VALUES ('$col_values')";
        $result = $conn->query($query);
        if ($result == true) {
            alert('Новая запись добавлена успешно');
        } else {
            if ($conn->errno == 1062) {
                alert("Ошибка, добавить запись не удалось: " . $this->errno1062unic);
            } else {
                alert("Неизвестная ошибка");
            }
        }
    }

    function update($id)
    {
        global $conn;
        include_once('db/db_conn_open.php');
        include_once('utils.php');
        $cols = array();
        foreach ($this->fields as $val) {
            $key = $val['name'];
            $value = $_POST[$val['name']];
            array_push($cols, "$key = '$value'");
        }
        $cols = join(", ", $cols);
        $query =
            "UPDATE " . $this->tableName . " SET $cols WHERE id = $id";
        $result = $conn->query($query);
        if ($result == true) {
            alert('Изменено!');
        } else {
            alert('Не удалось изменить: ' . $conn->error);
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
        $res = $conn->query($query);;
        if ($res == true) {
            $row = $res->fetch_assoc();
            echo "<script>
                    document.getElementById('title').textContent = '" . $this->editTitle . "';
                    document.getElementById('id').value = '$id';
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
            $this->set_disabled();
        } else {
            alert('Не удалось загрузить данные');
        }
    }

    function set_disabled()
    {
        if ($this->disabled_cols) {
            foreach ($this->disabled_cols as $val) {
                echo "<script>
           document.getElementById('$val').disabled = true;
           </script>;";
            }
        }
    }
}