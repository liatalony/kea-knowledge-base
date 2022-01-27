<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/router.php');
if (!is_csrf_valid()) {
    session_destroy();
    $message = "Something went wrong and we had to log you out. please try again.";
    echo "<script type='text/javascript'>alert('$message'); window.location.replace('/webdev/kea-kb/login');</script>";
    exit();
}
if ($_SESSION['user_role'] == 2) {
    if (!isset($_POST['first_name'])) {
        header('Location: /webdev/kea-kb/profile');
        echo 'first name';
        exit();
    }

    if (!isset($_POST['last_name'])) {
        header('Location: /webdev/kea-kb/profile');
        echo 'last name';
        exit();
    }

    if (!isset($_POST['email'])) {
        header('Location: /webdev/kea-kb/profile');
        echo 'email';
        exit();
    }


    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('Location: /webdev/kea-kb/profile');
        echo 'bad email';
        exit();
    }
}

if (!isset($_POST['pass'])) {
    header('Location: /webdev/kea-kb/profile');
    echo 'password';
    exit();
}

if (!isset($_POST['con_pass'])) {
    header('Location: /webdev/kea-kb/profile');
    echo 'con password';
    exit();
}

if (
    strlen($_POST['pass']) < 6
) {
    header('Location: /webdev/kea-kb/profile');
    echo 'password length';
    exit();
}

$number = preg_match('@[0-9]@', $_POST['pass']);
$uppercase = preg_match('@[A-Z]@', $_POST['pass']);
$lowercase = preg_match('@[a-z]@', $_POST['pass']);
$specialChars = preg_match('@[^\w]@', $_POST['pass']);

if (strlen($_POST['pass']) < 6 || !$number || !$uppercase || !$lowercase || !$specialChars) {
    header('Location: /webdev/kea-kb/profile');
    echo 'password length';
    exit();
}

if (
    $_POST['con_pass'] != $_POST['pass']
) {
    header('Location: /webdev/kea-kb/profile');
    echo 'passwords dont match';
    exit();
}

$pepper = "87d6452f30effac18a0ebfd7cfcdd4cc";
$salt = bin2hex(openssl_random_pseudo_bytes(10));
$hashed_salted = hash("sha256", $_POST['pass'] . $salt . $pepper);

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    if ($_SESSION['user_role'] == 2) {
        $q = $db->prepare(' UPDATE users
                        SET first_name = :first_name,
                            last_name = :last_name,
                            email = :email,
                            salt = :salt,
                            user_password = :user_password
                        WHERE user_uuid = :user_uuid ');
        $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
        $q->bindValue(':first_name', $_POST['first_name']);
        $q->bindValue(':last_name', $_POST['last_name']);
        $q->bindValue(':email', $_POST['email']);
        $q->bindValue(':salt', $salt);
        $q->bindValue(':user_password', $hashed_salted);
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
        header('Location: /webdev/kea-kb/admin');
        exit();
    }
    header('Location: /webdev/kea-kb/profile');
    exit();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
