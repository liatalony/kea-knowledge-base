<?php
$minutes = '-5 minutes';
$now = 'now';
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $q = $db->prepare(' SELECT * FROM login_log
                        WHERE user_email=:user_email AND logged_at >= datetime(:now, :minutes, :localtime)');
    $q->bindValue(':user_email', $_SESSION['user_email']);
    $q->bindValue(':minutes', '-5 minutes');
    $q->bindValue(':now', 'now');
    $q->bindValue(':localtime', 'localtime');

    $q->execute();
    $numOfLogins = $q->fetchAll();
    foreach ($numOfLogins as $login) {
        echo $login['logged_at'], '<br>';
    }
    //echo var_dump($numOfLogins);
    if (count($numOfLogins) >= 1) {
        $q = $db->prepare(' INSERT INTO login_log (user_email, logged_at) 
        VALUES(:user_email, datetime(:now, :localtime))');
        $q->bindValue(':user_email', $_SESSION['user_email']);
        $q->bindValue(':now', 'now');
        $q->bindValue(':localtime', 'localtime');
        $q->execute();
        echo 'still blocked';
        $_SESSION['error'] = 'This account is currently blocked. Please try again later.';
        header('Location: /webdev/kea-kb/login');
        exit();
    } else {
        echo 'not blocked anymore';
        $_SESSION['block'] = 0;
        require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/bridges/bridge_block_user.php');
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
