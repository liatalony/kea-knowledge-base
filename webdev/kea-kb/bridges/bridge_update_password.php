<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/router.php');

if (!is_csrf_valid()) {
    session_destroy();
    $message = "Something went wrong and we had to log you out. please try again.";
    echo "<script type='text/javascript'>alert('$message'); window.location.replace('/webdev/kea-kb/login');</script>";
    exit();
}
if (!isset($_POST['pass'])) {
    header("Location: /webdev/kea-kb/reset-pass/{$_POST['user_uuid']}");
    echo 'password';
    exit();
}

if (!isset($_POST['con_pass'])) {
    header("Location: /webdev/kea-kb/reset-pass/{$_POST['user_uuid']}");
    echo 'con password';
    exit();
}

if (
    strlen($_POST['pass']) < 6 ||
    strlen($_POST['pass']) > 8
) {
    header("Location: /webdev/kea-kb/reset-pass/{$_POST['user_uuid']}");
    echo 'password length';
    exit();
}

if (
    $_POST['con_pass'] != $_POST['pass']
) {
    header("Location: /webdev/kea-kb/reset-pass/{$_POST['user_uuid']}");
    echo 'passwords dont match';
    exit();
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

try {

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(' UPDATE users
                        SET user_password = :password
                        WHERE user_uuid = :user_uuid');
    $q->bindValue(':user_uuid', $_POST['user_uuid']);
    $q->bindValue(':password', $_POST['pass']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /webdev/kea-kb/login');
        exit();
    }

    header('Location: /webdev/kea-kb/signup');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
