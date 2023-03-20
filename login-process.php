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
    var_dump($pdo);
}   catch(PDOException $e) {
    exit('Une erreur est survenue : ' . $e->getCode() . ' - '. $e->getMessage());
}

// processus de connexion , on vient récuperer les colonnes que l'on veut

$login = $_POST['login'];
$password = $_POST['pass'];

// requête SQL pour récuperer la colonne 
$query = "SELECT * FROM Utilisateur WHERE login = :login";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':login', $login);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC); 

session_start();
if ($user == $user AND $password == $user['pass']) {
    $_SESSION['connected'] = true;
    header("location: Accueil.php?success=1");
    exit;
} else {
    header("location: login.php?error=1");
}
