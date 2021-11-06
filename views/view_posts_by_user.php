<?php 

require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');

session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}

try {
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
$db = new PDO("sqlite:$db_path");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$q = $db->prepare('SELECT post_id, post_text, post_time FROM posts
                    WHERE user_uuid = :user_uuid
                    ORDER BY post_time DESC 
                    ');
                       $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
$q->execute();
$posts = $q->fetchAll();

echo '<div id="posts">';
foreach ($posts as $post) {
?>
    <div class="single_post_wrapper">
        <div>Post text: <?=$post['post_text']?></div>
        <div>Post id: <?=$post['post_id']?></div>
        <div>Post time: <?=$post['post_time']?></div>
        <div class="comment_wrapper">
            <form action="comment" method="POST" onsubmit="return validate()" enctype="multipart/form-data">
                <label for="your_message">Leave a comment</label>
                <input type="hidden" name="postId" value="<?= $post['post_id'] ?>"/>
                <input style="width:250px" type="text" placeholder="Write your comment here" data-validate="str" name="message" autocomplete="off">            
                <button style="width:50px">Send</button>
            </form>

            <a href="/post/<?= $post['post_id'] ?>">See post</a>
        </div>
    </div>
<?php
}
echo '</div>';
} catch (PDOException $ex) {
echo $ex;
}