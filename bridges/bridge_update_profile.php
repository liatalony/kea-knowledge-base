<?php
session_start();
if ($_SESSION['user_role'] == 2) {
    if (!isset($_SESSION['user_uuid'])) {
        header('Location: /login');
        exit();
    }
    if (!isset($_POST['first_name'])) {
        header('Location: /profile');
        echo 'first name';
        exit();
    }

    if (!isset($_POST['last_name'])) {
        header('Location: /profile');
        echo 'last name';
        exit();
    }

    if (!isset($_POST['email'])) {
        header('Location: /profile');
        echo 'email';
        exit();
    }

    if (!isset($_POST['age'])) {
        header('Location: /profile');
        echo 'age';
        exit();
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('Location: /profile');
        echo 'bad email';
        exit();
    }
}

if (!isset($_POST['pass'])) {
    header('Location: /profile');
    echo 'password';
    exit();
}

if (!isset($_POST['con_pass'])) {
    header('Location: /profile');
    echo 'con password';
    exit();
}

if (
    strlen($_POST['pass']) < 6 ||
    strlen($_POST['pass']) > 8
) {
    header('Location: /profile');
    echo 'password length';
    exit();
}

if (
    $_POST['con_pass'] != $_POST['pass']
) {
    header('Location: /profile');
    echo 'passwords dont match';
    exit();
}


try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    if ($_SESSION['user_role'] == 2) {
        $q = $db->prepare(' UPDATE users
                        SET first_name = :first_name,
                            last_name = :last_name,
                            email = :email,
                            age = :age,
                            user_password = :user_password
                        WHERE user_uuid = :user_uuid ');
        $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
        $q->bindValue(':first_name', $_POST['first_name']);
        $q->bindValue(':last_name', $_POST['last_name']);
        $q->bindValue(':email', $_POST['email']);
        $q->bindValue(':age', $_POST['age']);
        $q->bindValue(':user_password', password_hash($_POST['pass'], PASSWORD_DEFAULT));
    }
    if ($_SESSION['user_role'] == 1) {
        $q = $db->prepare(' UPDATE users
                        SET user_password = :user_password
                        WHERE user_uuid = :user_uuid ');
        $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
        $q->bindValue(':user_password', password_hash($_POST['pass'], PASSWORD_DEFAULT));
    }
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /admin');
        exit();
    }
    header('Location: /profile');
    exit();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
