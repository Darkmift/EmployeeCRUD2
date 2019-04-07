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
    public function update($id, array $params)
    {
        $database = PDOClass::getInstance();

        $query = "UPDATE " . $this->table . " SET ";
        foreach ($params as $key => $value) {
            $query .= "`$key`= :$key,";
        }
        $query = rtrim($query, ',');
        $query .= ' WHERE `id`= :id';
        $database->query($query);

        foreach ($params as $key => $value) {
            $database->bind(":$key", $value, PDO::PARAM_STR);
        }
        $database->bind(":id", $id, PDO::PARAM_INT);
        $database->execute();
        $database->terminate();
    }

    //delete row
    public function delete($id)
    {
        $database = PDOClass::getInstance();
        $database->query("DELETE FROM " . $this->table . " WHERE `id` = :id");
        $database->bind(':id', $id, PDO::PARAM_STR);
        $database->execute();
        $database->terminate();
    }

}
