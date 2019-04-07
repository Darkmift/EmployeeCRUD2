<?php
require 'models/Employee.php';
$employeeData = new Employee();
$employee_list;
try {
    $employee_list = $employeeData->getAll();
} catch (PDOEXCEPTION $e) {
    $employeeData = array();
    $employee_list = $employeeData['error']['errorMsg'] = 'Action failed! Error Code: ' . $e->getCode();
}
if (isset($_POST['edit_id'])) {
    $edit_id = filter_var($_POST['edit_id'], FILTER_SANITIZE_NUMBER_INT);
    $action = $id = filter_var($_POST['action'], FILTER_SANITIZE_STRING);
    // print_r([$edit_id, $action]);
    foreach ($employee_list as $employee_location_int => $employee_array) {
        if ($employee_array['id'] == $edit_id) {
            print_r($employee_array);
            $employee_list[$employee_location_int]['edit'] = true;
        }
    }

    switch ($action) {
        case 'update':
            break;

        case 'delete':
            # code...
            break;
    }
}
