<?php
require 'Controller.php';

$employee_list = Controller::getList();

if (isset($_POST['action'])) {

    // prettyPrintR($_POST);

    $action = Controller::sanitize($_POST['action']);
    $edit_id = Controller::sanitize($_POST['edit_id']);

    //init list pass to tbody
    $employee_list = Controller::edit($employee_list, $edit_id, $action);
    //save row that activated post
    $original = $employee_list[0][$employee_list[1]];
    //send list to body
    $employee_list = $employee_list[0];

    echo $_POST['action'];
    switch ($action) {
        case 'confirm':
            if (Controller::confirm($_POST, $original)) {
                $employee_list = Controller::getList();
            }
            break;

        case 'remove':
            Controller::delete($edit_id);
            $employee_list = Controller::getList();
            break;

        default:
            # code...
            break;
    }
}

function prettyPrintR($param)
{
    print("<pre>" . print_r($param, true) . "</pre><hr>");
}
