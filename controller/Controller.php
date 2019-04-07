<?php
require 'models/Employee.php';
class Controller
{

    public function getList()
    {
        try {
            $employees = new Employee();
            $employeeData = $employees->getAll();
        } catch (PDOEXCEPTION $e) {
            $employeeData = array();
            return $employeeData['error']['errorMsg'] = 'Action failed! Error Code: ' . $e->getCode();
        }
        return $employeeData;
    }

    public static function sanitize($param)
    {
        return filter_var($param, FILTER_SANITIZE_STRING);
    }

    //convert row to form
    public static function edit($emp_list, $edit_id, $action)
    {
        $emp_id;
        foreach ($emp_list as $emp_list_id => $employee) {
            if ($employee['id'] == $edit_id) {
                $emp_list[$emp_list_id]['action'] = $action;
                $emp_id = $emp_list_id;
            }
        }
        return [$emp_list, $emp_id];
    }

    public static function delete($id)
    {
        $employeeData = new Employee();
        $employeeData->delete($id);
    }

    public static function update()
    {

    }

    public static function confirm(array $params, array $original)
    {

        $id = self::sanitize($params['edit_id']);
        $serial_num = self::sanitize($params['serial_num']);
        $firstname = self::sanitize($params['firstname']);
        $lastname = self::sanitize($params['lastname']);
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
            $employeeData = new Employee();
            $employeeData->update($id, $update_params);
            return true;
        }
        return false;
    }

    public static function cancel()
    {

    }

}
