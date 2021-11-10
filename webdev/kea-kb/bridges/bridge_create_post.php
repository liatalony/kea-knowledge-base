<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}

$validExtensions = ['png', 'jpg', 'jpeg', 'gif'];
$imageType = mime_content_type($_FILES['screenshot']['tmp_name']);
$extension = strrchr($imageType, '/');
$extension = ltrim($extension, '/');
// echo $extension;

if (!in_array($extension, $validExtensions)) {
    $imageName = "none";
    echo "Image type not supported";
} else {
    $imageName = bin2hex(random_bytes(10)) . ".$extension";
    move_uploaded_file($_FILES['screenshot']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/webdev/kea-kb/images/$imageName");
}

try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(
        'INSERT INTO posts
                        VALUES (
                            :post_id, 
                            :post_text, 
                            :post_image_path, 
                            :post_time, 
                            :post_time_last_edit, 
                            :user_uuid)'
    );
    $q->bindValue(':post_id', bin2hex(random_bytes(16)));
    $q->bindValue(':post_text', $_POST['message']);
    // $q->bindValue(':post_image_path', bin2hex(random_bytes(16)));
    if ($imageName == "none") {
        $q->bindValue(':post_image_path', "none");
    } else {
        $q->bindValue(':post_image_path', "/webdev/kea-kb/images/$imageName");
    }
    $q->bindValue(':post_time', date("Y-m-d H:i:s"));
    $q->bindValue(':post_time_last_edit', date("Y-m-d H:i:s"));
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->execute();
    $post = $q->fetch();
    // echo "Hi {$user['first_name']} {$user['last_name']}";
    header('Location: /webdev/kea-kb/post');
} catch (PDOException $ex) {
    echo $ex;
}
