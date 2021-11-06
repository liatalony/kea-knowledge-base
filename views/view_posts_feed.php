<?php 
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
$q = $db->prepare('SELECT * FROM posts
                    INNER JOIN users
                    ON posts.user_uuid = users.user_uuid
                    ORDER BY post_time DESC 
                    ');
$q->execute();
$posts = $q->fetchAll();

echo '<div id="posts">';
foreach ($posts as $post) {
?>
    <div class="single_post_wrapper">
        <div><?=$post['first_name']?></div>
        <div><?=$post['post_text']?></div>
        <div><?=$post['post_time']?></div>
        <div class="comment_wrapper">
            <form action="comment" method="POST" onsubmit="return validate()" enctype="multipart/form-data">
                <label for="your_message">Leave a comment</label>
                <input style="width:250px" type="text" placeholder="Write your comment here" data-validate="str" name="message" autocomplete="off">            
                <button style="width:50px">Send</button>
            </form>
        </div>
    </div>
<?php
}
echo '</div>';
} catch (PDOException $ex) {
echo $ex;
}