<?php

[
    'dbname' => $dbname,
    'host' => $host,
    'port' => $port,
    'charset' => $charset,
    'user' => $user,
    'password' => $password
] = parse_ini_file(__DIR__ . "/config/db.ini");

$dsn = "mysql:host=host.docker.internal;port=8889;dbname=Projet_PHP;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

try{
    $pdo = new PDO($dsn, $user, $password, $options);
}   catch(PDOException $e) {
    exit('Une erreur est survenue : ' . $e->getCode() . ' - '. $e->getMessage());
}