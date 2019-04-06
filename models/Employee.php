<?php
require 'PDOClass.php';

class Employee
{
    private static $PDO_instance;
    private $table = 'info';

    public function getone($id)
    {
        $database = PDOClass::getInstance();
        $database->query("SELECT `column` FROM " . $this->table . " WHERE `columnValue` = :id");
        $database->bind(':id', 123);
        return $database->single();
    }

    public function getAll()
    {
        $database = PDOClass::getInstance();
        // var_dump($database);
        // die();
        $database->query("SELECT * FROM " . $this->table);
        return $database->resultSet();
    }

    //insert new employee
    public function add(array $array)
    {
        $database = PDOClass::getInstance();
        $database->query("INSERT INTO " . $this->table . " (serial_num, firstname, lastname) VALUES (:serial_num, :firstname, :lastname)");
        $database->bind(':serial_num', $array['serial_num'], PDO::PARAM_STR);
        $database->bind(':firstname', $array['firstname'], PDO::PARAM_STR);
        $database->bind(':lastname', $array['lastname'], PDO::PARAM_STR);
        $database->execute();
        $database->terminate();
    }

    //modify row
    public function update($serial_num, $param, $newVal)
    {
        $database = PDOClass::getInstance();
        $database->query("UPDATE " . $this->table . " SET `:param` = :value WHERE `serial_num` = :serial_num");
        $database->bind(':param', $param);
        $database->bind(':value', $newVal, PDO::PARAM_STR);
        $database->bind(':serial_num', $serial_num, PDO::PARAM_STR);
        $database->execute();
        $database->terminate();
    }

    //delete row
    public function delete($serial_num)
    {
        $database = PDOClass::getInstance();
        $database->query("DELETE FROM " . $this->table . " WHERE `serial_num` = :serial_num");
        $database->bind(':serial_num', $serial_num, PDO::PARAM_STR);
        $database->execute();
        $database->terminate();
    }

}
