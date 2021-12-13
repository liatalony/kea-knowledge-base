<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}
if ($_SESSION['user_role'] != 1) {
    header('Location: /webdev/kea-kb/404');
    exit();
}
try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare('UPDATE users SET active=0 WHERE user_uuid = :user_uuid');
    $q->bindValue(':user_uuid', $user_id);
    $q->execute();
} catch (PDOException $ex) {
    echo $ex;
}
