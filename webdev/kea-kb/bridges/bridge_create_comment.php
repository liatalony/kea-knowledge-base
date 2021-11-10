<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}

try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
    $db = new PDO("sqlite:$db_path");
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
    header('Location: /webdev/kea-kb/feed');
} catch (PDOException $ex) {
    echo $ex;
}
