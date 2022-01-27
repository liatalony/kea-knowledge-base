<?php
// echo $_SESSION['user_name'];
// exit();
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $q = $db->prepare(' UPDATE users
                        SET is_blocked = :is_blocked
                        WHERE email=:user_email');
    $q->bindValue(':user_email', $_SESSION['user_email']);
    $q->bindValue(':is_blocked', $_SESSION['block']);
    $q->execute();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
