<?php

class PDOClass
{
    private static $_instance = null;
    private $_stmt;
    private $serverHost = 'localhost';
    private $dbname = 'employee';
    private $userName = 'root';
    private $passWord = '';
    private $pdoConfig = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    //init PDO obj for pre conn
    function __construct()
    {
        try {
            $this->dbhost = new PDO('mysql:host=' . $this->$serverHost . ';dbname=' . $this->$dbname, $this->$userName, $this->$passWord, $this->$pdoConfig);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    //set PDO as singelton
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new PDOClass();
        }
        return self::$_instance;
    }

    //force termination of PDO instance
    public function terminate()
    {
        return self::$_instance = null;
    }

    //set a query method
    public function query($query)
    {
        $this->_stmt = $this->dbhost->prepare($query);
    }

    //set a bind method
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->_stmt->bindValue($param, $value, $type);
    }

    //execute query
    public function execute()
    {
        return $this->_stmt->execute();
    }

    //get rowCount
    public function rowCount()
    {
        return $this->_stmt->rowCount();
    }

    //single row
    public function single()
    {
        $this->execute();
        return $this->_stmt->fetch(PDO::FETCH_ASSOC);
    }

    //multiple rows
    public function resultSet()
    {
        $this->execute();
        return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
