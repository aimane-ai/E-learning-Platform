<?php
    $host = 'localhost';
    $dbname = 'your_database_name';
    $username = 'your_db_user';
    $password = 'your_db_password';

    try{
        $connexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        die("Unable to connect to database $dbname: " . $e->getMessage());
    }
?>