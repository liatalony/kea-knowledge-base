<?php
try {
    $sDatabaseUserName = 'u259301546_keakbadmin';
    $sDatabasePassword = 'KeaKBadminpass123';
    $sDatabaseConnection = "mysql:host=localhost; dbname=u259301546_keakb; charset=utf8mb4";

    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    // $aDatabaseOptions = array(
    //     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ // Array with object
    // );
    $db = new PDO($sDatabaseConnection, $sDatabaseUserName, $sDatabasePassword);
} catch (PDOException $e) {
    echo '{"status":0,"message":"cannot connect to database"}';
    exit();
}
