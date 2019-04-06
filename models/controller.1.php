<?php
header('Content-Type: application/json');
require 'PDO.php';
$errMsg = array();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':

        switch ($_GET['action']) {
            case 'getAll':
                triggerDB('getAll', '', $conn);
                break;
            case 'getOne':
                $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
                triggerDB('getOne', $id, $conn);
                break;
        }
        break;
    case 'POST':
        //filter input
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $recruitment_date = filter_var($_POST['recruitment_date'], FILTER_SANITIZE_STRING);
 
        //validate input
        if (strlen($id) > 9) {
            array_push($errMsg, array('notice' => 'id length too big!'));
        }
        if (!strtotime($recruitment_date)) {
            array_push($errMsg, array('notice' => 'date structure invalid!'));
        }
        //echo errors if any
        if (!empty($errMsg)) {
            echo json_encode(array("error" => $errMsg));
            http_response_code(400);
            break;
        }
        $data = new stdClass();
        $data->id = $id;
        $data->name = $name;
        $data->recruitment_date = $recruitment_date;
        triggerDB('addNew', $data, $conn);
        http_response_code(200);
        break;
    case 'DELETE':
        $request_vars = array();
        parse_str(file_get_contents('php://input'), $request_vars);
        $id = filter_var($request_vars['id'], FILTER_SANITIZE_STRING);
        triggerDB('delete', $id, $conn);
        http_response_code(200);
        break;
    case 'PUT':
        $request_vars = array();
        parse_str(file_get_contents('php://input'), $request_vars);
        $id = filter_var($request_vars['id'], FILTER_SANITIZE_STRING);
        $name = filter_var($request_vars['name'], FILTER_SANITIZE_STRING);
        $data = new stdClass();
        $data->id = $id;
        $data->name = $name;
        triggerDB('update', $data, $conn);
        http_response_code(200);
        break;
    default:
        http_response_code(400);
}

function triggerDB($action, $inputObj, $conn)
{
    switch ($action) {
        case 'addNew':
            try
            {
                // prepare and bind
                $stmt = $conn->prepare("INSERT INTO employees (id, name,recruitment_date ) VALUES (:id,:name, :recruitment_date)");
                $stmt->bindParam(':id', $inputObj->id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $inputObj->name, PDO::PARAM_STR);
                $stmt->bindParam(':recruitment_date', $inputObj->recruitment_date, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                //echo $e->getMessage();
                if ($e->errorInfo[1] == 1062) {
                    output('error', "Employee id($inputObj->id) already exist!");
                    break;
                }
                output('error', $e->errorInfo);
                break;
            }
            $stmt = $conn->prepare("SELECT * FROM employees WHERE id=:id");
            $stmt->execute(['id' => $inputObj->id]);
            $user = $stmt->fetch();
            output('success', $user);
            break;
        case 'getAll':
            $stmt = $conn->prepare("SELECT * FROM employees");
            $stmt->execute();
            $list = $stmt->fetchAll();
            output('success', $list);
            break;
        case 'getOne':
            $stmt = $conn->prepare("SELECT * FROM employees WHERE id=:id");
            $stmt->execute(['id' => $inputObj]);
            $user = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                output('success', $user);
            } else {
                output('error', "Employee id($inputObj) does not exist in DB!");
            }
            break;
        case 'delete':
            try
            {
                // prepare and bind
                $stmt = $conn->prepare("DELETE FROM employees WHERE id=:id");
                $stmt->execute(['id' => $inputObj]);
            } catch (PDOException $e) {
                output('error', $e->errorInfo);
                break;
            }
            output('success', "no errors in execution");
            break;
        case 'update':
            try
            {
                // prepare and bind
                $stmt = $conn->prepare("UPDATE employees SET name= :name WHERE id=:id");
                $stmt->bindParam(':id', $inputObj->id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $inputObj->name, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                output('error', $e->errorInfo);
                break;
            }
            $count = $stmt->rowCount();
            if ($stmt->rowCount() > 0) {
                $stmt = $conn->prepare("SELECT * FROM employees WHERE id=:id");
                $stmt->execute(['id' => $inputObj->id]);
                $user = $stmt->fetch();
                output('success', $user);
            } else {
                output('error', "employee Id $inputObj->id not found,update aborted");
            }
            break;
    }
}

function output($status, $msg)
{
    $output = new stdClass();
    $output->{$status} = $msg;
    echo json_encode($output);
}
