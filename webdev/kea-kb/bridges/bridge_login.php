<?php


if (!isset($_POST['email'])) {
    header('Location: /webdev/kea-kb/login');
    echo 'email';
    exit();
}
if (!isset($_POST['pass'])) {
    header('Location: /webdev/kea-kb/login');
    echo 'password';
    exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: /webdev/kea-kb/login');
    echo 'bad email';
    exit();
}

$pepper = "87d6452f30effac18a0ebfd7cfcdd4cc";

try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
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
        header('Location: /webdev/kea-kb/login');
        exit();
    }
    if (hash("sha256", $_POST['pass'] . $user['salt'] . $pepper) !=  $user['user_password']) {
        session_start();
        $_SESSION['error'] = 'Wrong email or password';
        $_SESSION['user_email'] = $user['email'];
        require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/bridges/bridge_login_log.php');
        header('Location: /webdev/kea-kb/login');
        exit();
    }

    if ($user['is_blocked'] == 1) {
        session_start();
        $_SESSION['user_email'] = $user['email'];
        require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/bridges/bridge_check_block.php');
    }
    session_start();
    $_SESSION['user_uuid'] = $user['user_uuid'];
    $_SESSION['user_role'] = $user['user_role'];

    header('Location: /webdev/kea-kb/feed');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
