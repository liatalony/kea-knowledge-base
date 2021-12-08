<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/router.php');
if (!is_csrf_valid()) {
    session_destroy();
    $message = "Something went wrong and we had to log you out. please try again.";
    echo "<script type='text/javascript'>alert('$message'); window.location.replace('/webdev/kea-kb/login');</script>";
    exit();
}
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}

if (!isset($_FILES['pic'])) {
    header('Location: /webdev/kea-kb/profile');
    echo 'pic';
    exit();
}
echo var_dump($_FILES['pic']);
$valid_extensions = ['png', 'jpg', 'jpeg', 'gif', 'zip', 'pdf'];
$image_type = mime_content_type($_FILES['pic']['tmp_name']); // image/png
$extension = strrchr($image_type, '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain

if (!in_array($extension, $valid_extensions)) {
    echo "mmm.. hacking me?";
    header('Location: /webdev/kea-kb/profile');
    exit();
}
$random_image_name = bin2hex(random_bytes(16)) . ".$extension";
move_uploaded_file($_FILES['pic']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/webdev/kea-kb/images/$random_image_name");
echo 'File uploaded';

try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(' UPDATE users
                        SET image_path=:image_path
                        WHERE user_uuid = :user_uuid ');
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':image_path', "/webdev/kea-kb/images/$random_image_name");
    $q->execute();
    $user = $q->fetch();

    header('Location: /webdev/kea-kb/profile');
    exit();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
