<?php
$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= $_SERVER['REQUEST_URI'];

////////
if (isset($_POST['action'])) {
    $action = filter_var($_POST['action'], FILTER_SANITIZE_STRING);
    if (isset($_POST['edit_id'])) {
        $edit_id = filter_var($_POST['edit_id'], FILTER_SANITIZE_NUMBER_INT);
        // prettyPrintR($_POST);

        foreach ($employee_list as $employee_location_int => $employee_array) {
            if ($employee_array['id'] == $edit_id) {
                $original = $employee_list[$employee_location_int];
                $employee_list[$employee_location_int]['action'] = $action;
            }
        }

        switch ($action) {
            case 'update':
            case 'delete':

                break;
            case 'confirm':

                $id = filter_var($_POST['edit_id'], FILTER_SANITIZE_STRING);
                $serial_num = filter_var($_POST['serial_num'], FILTER_SANITIZE_STRING);
                $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
                $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);

                $update_params = array();
                switch (true) {
                    case $original['serial_num'] != $serial_num:
                        $update_params['serial_num'] = $serial_num;

                    case $original['firstname'] != $firstname:
                        $update_params['firstname'] = $firstname;

                    case $original['lastname'] != $lastname:
                        $update_params['lastname'] = $lastname;

                }

                if (!empty($update_params)) {
                    prettyPrintR($update_params);
                    $employeeData->update($id, $update_params);
                    $employee_list = $employeeData->getAll();
                }

                break;
            case 'cancel':
                break;
        }
    }
}
