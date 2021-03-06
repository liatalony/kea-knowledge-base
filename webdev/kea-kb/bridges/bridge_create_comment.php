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
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare(
        'INSERT INTO comments
                        VALUES (
                            :comment_id, 
                            :comment_text, 
                            :comment_image_path, 
                            :comment_time, 
                            :comment_time_last_edit, 
                            :user_uuid, 
                            :post_id)'
    );
    $q->bindValue(':comment_id', bin2hex(random_bytes(16)));
    $q->bindValue(':comment_text', $_POST['message']);
    $q->bindValue(':comment_image_path', bin2hex(random_bytes(16)));
    $q->bindValue(':comment_time', date("Y-m-d H:i:s"));
    $q->bindValue(':comment_time_last_edit', date("Y-m-d H:i:s"));
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);

    // the next line is wrong - we need to somehow insert the post id 
    // which the comment refers to
    $q->bindValue(':post_id', $_POST['postId']);
    $q->execute();
    $comment = $q->fetch();
    $current_page = $_SESSION['current_page'];
    header("Location: /webdev/kea-kb/$current_page");
} catch (PDOException $ex) {
    echo $ex;
}
