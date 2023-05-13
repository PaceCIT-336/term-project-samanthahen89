<?php
// Use this file to create a local database connection
// Copy the following line into other php files to let them connect to the database
// require_once("db_connect.php");

$host = 'localhost';
$database = 'ticketing_system'; // enter your database name here
$user = 'projectapp'; // enter your database username here
$password = 'projectpass123'; // enter your database password here
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$database;charset=$chrs";
$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try
{
  $pdo = new PDO($attr, $user, $password, $opts);
}
catch (PDOException $e)
{
  throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>