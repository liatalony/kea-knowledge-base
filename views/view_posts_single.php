<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');

// get the post id from url:
$postId = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /login');
    exit();
}
?>

<div id="posts">

<?php    
try {
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
$db = new PDO("sqlite:$db_path");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$a = $db->prepare('SELECT *
                    FROM posts
                    INNER JOIN users
                    ON posts.user_uuid = users.user_uuid
                    WHERE posts.post_id = :post_id');
$a->bindValue(':post_id', $postId);
$a->execute();
$post = $a->fetch();

$q = $db->prepare('SELECT *
                    FROM comments
                    INNER JOIN users
                    ON comments.user_uuid = users.user_uuid
                    WHERE comments.post_id = :post_id');
$q->bindValue(':post_id', $postId);
$q->execute();
$comments = $q->fetchAll();
?>

    <h2><?= $post['post_text'] ?></h2>
    <p>posted by: <?= $post['first_name'].' '.$post['last_name']?></h2>
    <div class="img">
    <img src="/images/<?= $post['post_image_path'] ?>" alt="screenshot">
    </div>

<?php     
foreach ($comments as $comment) {
?>

    <div class="single_post_wrapper">
        <div class="comment_wrapper">
            <div>
                <p><?= $comment['comment_text']?></p>
                <p><?= $comment['comment_time']?></p>
                <br>
                <p>Comment by: <?= $comment['first_name']?></p>
            </div>
        </div>
    </div>
    
<?php
}
?>
        <br>
        <h3>Leave new comments:</h3>
        <div class="comment_wrapper">
            <form action="comment" method="POST" onsubmit="return validate()" enctype="multipart/form-data">
                <label for="your_message">Leave a comment</label>
                <input type="hidden" name="postId" value="<?= $post['post_id'] ?>"/>
                <input style="width:250px" type="text" placeholder="Write your comment here" data-validate="str" name="message" autocomplete="off">            
                <button style="width:50px">Send</button>
            </form>
        </div>

</div>
<?php
} catch (PDOException $ex) {
echo $ex;
}