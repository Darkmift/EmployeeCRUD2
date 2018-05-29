<?php

//host of SQL:
$host = "localhost";
//sql user:
$user = "root";
//sql user pw:
$pass = "root12";
//DB to conect/create:
$db = "employees";
$table = "employees";
$dsn = "mysql:host=$host;dbname=$db;";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
//set flag for DB operations...true if DB and table are ready for work
$dbOk = false;

try {
    $conn = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
    die(
        json_encode(
            array("error" => $e->getMessage()),
            true
        )
    );
    exit;
}
