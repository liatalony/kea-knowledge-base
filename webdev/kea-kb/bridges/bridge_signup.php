<?php

if (!isset($_POST['first_name'])) {
    header('Location: /webdev/kea-kb/signup');
    echo 'first name';
    exit();
}

if (!isset($_POST['last_name'])) {
    header('Location: /webdev/kea-kb/signup');
    echo 'last name';
    exit();
}

if (!isset($_POST['email'])) {
    header('Location: /webdev/kea-kb/signup');
    echo 'email';
    exit();
}
if (!isset($_POST['pass'])) {
    header('Location: /webdev/kea-kb/signup');
    echo 'password';
    exit();
}

if (!isset($_POST['con_pass'])) {
    header('Location: /webdev/kea-kb/signup');
    echo 'con password';
    exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: /webdev/kea-kb/signup');
    echo 'bad email';
    exit();
}
if (
    strlen($_POST['pass']) < 6 ||
    strlen($_POST['pass']) > 8
) {
    header('Location: /webdev/kea-kb/signup');
    echo 'password length';
    exit();
}

if (
    $_POST['con_pass'] != $_POST['pass']
) {
    header('Location: /webdev/kea-kb/signup');
    echo 'passwords dont match';
    exit();
}

$pepper = "87d6452f30effac18a0ebfd7cfcdd4cc";

$salt = bin2hex(openssl_random_pseudo_bytes(10));
$hashed_salted = hash("sha256", $_POST['pass'] . $salt . $pepper);
try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(' INSERT INTO users
                    VALUES (:user_uuid , :first_name , :last_name , :email, :salt , :password ,:user_role, :active, :image_path)');
    $q->bindValue(':user_uuid', bin2hex(random_bytes(16)));
    $q->bindValue(':first_name', $_POST['first_name']);
    $q->bindValue(':last_name', $_POST['last_name']);
    $q->bindValue(':email', $_POST['email']);
    $q->bindValue(':salt', $salt);

    $q->bindValue(':password', $hashed_salted);
    //$q->bindValue(':password', password_hash($_POST['pass'], PASSWORD_DEFAULT));

    $q->bindValue(':user_role', 2);
    $q->bindValue(':active', 1);
    $q->bindValue(':image_path', "/images/default.jpg");
    $q->execute();
    $user = $q->fetch();


    if (!$user) {
        //SEND EMAIL
        // require_once($_SERVER['DOCUMENT_ROOT'].'/bridges/bridge_activate.php');
        header('Location: /webdev/kea-kb/login');
        exit();
    }

    header('Location: /webdev/kea-kb/signup');
    exit();
} catch (PDOException $ex) {
    echo $ex->getMessage();
    // header('Location: /404');
}
