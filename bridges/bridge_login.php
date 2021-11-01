<?php

if (!isset($_POST['email'])) {
    header('Location: /login');
    echo 'email';
    exit();
}
if (!isset($_POST['pass'])) {
    header('Location: /login');
    echo 'password';
    exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: /login');
    echo 'bad email';
    exit();
}


try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(' SELECT * FROM users 
                        WHERE email = :email 
                        AND active = 1 LIMIT 1');
    $q->bindValue(':email', $_POST['email']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /login');
        exit();
    }
    if (!password_verify($_POST['pass'], $user['user_password'])) {
        header('Location: /login');
        exit();
    }
    session_start();
    $_SESSION['user_uuid'] = $user['user_uuid'];
    $_SESSION['user_role'] = $user['user_role'];

    header('Location: /admin');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
