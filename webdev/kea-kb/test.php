<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=u259301546_keakb", 'u259301546_keakbadmin', 'KeaKBadminpass123');
    echo "Connected to database at successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database:" . $pe->getMessage());
}
