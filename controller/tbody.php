<?php
$count = 1;
foreach ($employee_list as $employee) {
    echo '<tr>';
    if (isset($employee['action'])) {
        switch ($employee['action']) {
            case 'update':
                echo renderRow($employee, 'update', $count);
                echo renderButtons($employee['id'], ['confirm', 'cancel']);
                break;

            case 'delete':
                echo renderRow($employee, 'delete', $count);
                echo renderButtons($employee['id'], ['remove', 'cancel']);
                break;
            case 'cancel':
                echo renderRow($employee, 'cancel', $count);
                echo renderButtons($employee['id'], ['update', 'delete']);
                break;
            case 'confirm':
            case 'remove':
                echo renderRow($employee, 'confirm', $count);
                echo renderButtons($employee['id'], ['update', 'delete']);
                break;
        }
    } else {
        echo renderRow($employee, 'default', $count);
        echo renderButtons($employee['id'], ['update', 'delete']);
    }
    $count++;
}

function renderRow(array $employee, $action, $count)
{
    echo '<form action="index.php" method="POST">';
    if ($action == 'update') {
        foreach ($employee as $key => $value) {
            switch ($key) {
                case 'id':
                    echo "<td>" . $count . "</td>";
                    break;
                case 'serial_num':
                    echo '<td><input type="number" onkeydown="javascript: return event.keyCode == 69 ? false : true" name="' . $key . '" value="' . $value . '"/></td>';
                    break;
                case 'firstname':
                case 'lastname':
                    echo '<td><input type="text" name="' . $key . '" value="' . $value . '"/></td>';
                    break;
            }
        }
    } else {
        foreach ($employee as $key => $value) {
            switch ($key) {
                case 'id':
                    echo "<td>" . $count . "</td>";
                    break;
                case 'serial_num':
                case 'firstname':
                case 'lastname':
                    echo '<td>' . $value . '</td>';
                    break;
            }
        }
    }
}

function renderButtons($id, array $btnNames)
{
    return "<td>" .
        '<input type="hidden" name="edit_id" value=' . $id . '>' .
        '<button class="btn btn-labeled btn-warning" type="submit" name="action" value="' . $btnNames[0] . '" />
    <span"><i class="glyphicon glyphicon-pencil"></i></span>' .
        $btnNames[0] .
        '</button>&nbsp;&nbsp;' .
        '<button class="btn btn-labeled btn-danger" type="submit" name="action" value="' . $btnNames[1] . '" />
    <span><i class="glyphicon glyphicon-trash"></i></span>' .
        $btnNames[1] .
        '</button>' .
        "</form></td></tr>";
}
