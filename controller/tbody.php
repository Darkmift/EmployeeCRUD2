<?php
$count = 1;
foreach ($employee_list as $employee) {
    echo '<tr>';
    // print_r($employee);
    // echo '<hr>';
    if (isset($employee['edit'])) {
        echo '<form action="index.php" method="POST">';
        foreach ($employee as $key => $value) {
            switch ($key) {
                case 'id':
                    echo "<td>" . $count . "</td>";
                    break;
                case 'serial_num':
                    echo '<td><input type="number" name="fname" value="'. $value .'"/></td>';
                    break;
                case 'edit':
                    echo 'edit';
                    break;
                default:
                    echo '<td><input type="text" name="fname" value="' . $value . '"/></td>';
                    break;
            }
        }
        echo "<td>" .
            '<form action="index.php" method="POST">' .
            '<input type="hidden" name="edit_id" value=' . $employee['id'] . '>' .
            '<button class="btn btn-labeled btn-warning" type="submit" name="action" value="confirm" />
            <span"><i class="glyphicon glyphicon-pencil"></i></span>Confirm
            </button>&nbsp;&nbsp;' .
            '<button class="btn btn-labeled btn-success" type="submit" name="action" value="cancel" />
            <span><i class="glyphicon glyphicon-trash"></i></span>Abort
            </button>' .
            "</form></td>";
        echo '</tr>';
    } else {
        foreach ($employee as $key => $value) {
            switch ($key) {
                case 'errorMsg':
                    echo "<td colspan=4>$value</td>";
                    break;
                case 'id':
                    echo "<td>" . $count . "</td>";
                    break;
                case 'edit':
                    echo 'edit';
                    break;
                default:
                    echo "<td>$value</td>";
                    break;
            }
        }
        echo "<td>" .
            '<form action="index.php" method="POST">' .
            '<input type="hidden" name="edit_id" value=' . $employee['id'] . '>' .
            '<button class="btn btn-labeled btn-warning" type="submit" name="action" value="update" />
            <span"><i class="glyphicon glyphicon-pencil"></i></span>Update
            </button>&nbsp;&nbsp;' .
            '<button class="btn btn-labeled btn-danger" type="submit" name="action" value="delete" />
            <span><i class="glyphicon glyphicon-trash"></i></span>Delete
            </button>' .
            "</form></td>";
        echo '</tr>';
    }
    $count++;
}
