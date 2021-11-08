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
$q = $db->prepare('SELECT * FROM posts
                    INNER JOIN users
                    ON posts.user_uuid = users.user_uuid
                    ORDER BY post_time DESC 
                    ');
$q->execute();
$posts = $q->fetchAll();
?>

<h1>All posts from all users</h1>
<div id="posts">

<?php foreach ($posts as $post) {
?>
    <div class="single_post_wrapper">
        <h4><?=$post['post_text']?></h4>
        <div>Posted by:<?=$post['first_name']?></div>
        <div>Post time: <?=$post['post_time']?></div>
        <div class="comment_wrapper">
            <form action="comment" method="POST" onsubmit="return validate()" enctype="multipart/form-data">
                <label for="your_message">Leave a comment</label>
                <input type="hidden" name="postId" value="<?= $post['post_id'] ?>"/>
                <input style="width:250px" type="text" placeholder="Write your comment here" data-validate="str" name="message" autocomplete="off">            
                <button style="width:50px">Send</button>
                <a href="/post/<?= $post['post_id'] ?>">See post</a>
            </form>
        </div>
    </div>
<?php
}
?>

</div>

<?php
} catch (PDOException $ex) {
echo $ex;
}