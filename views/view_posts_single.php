<?php 

require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');

// get the post id from url:
$postId = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

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
    $q = $db->prepare('SELECT *
    -- posts.post_text, posts.post_id, posts.post_time
    FROM posts
    --WHERE post_id = :post_id
    WHERE post_id = :post_id');
    $q->bindValue(':post_id', $postId);
    $q->execute();
    $post = $q->fetch();
?>

<div id="posts">

    <h2>Post:</h2>
    <p><?= $post['post_text'] ?></p>
    
<?php
} catch (PDOException $ex) {
echo $ex;
}

try {
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
$db = new PDO("sqlite:$db_path");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$q = $db->prepare('SELECT comments.comment_text, comments.comment_time, posts.post_text, posts.post_time
-- posts.post_text, posts.post_id, posts.post_time
FROM comments
--WHERE post_id = :post_id
INNER JOIN posts
ON comments.post_id = posts.post_id
WHERE posts.post_id = :post_id');
$q->bindValue(':post_id', $postId);
$q->execute();
$posts = $q->fetchAll();

?>
    <h2>All comments/previous comments from this post:</h2>
<?php 
foreach ($posts as $post) {
?>
    <div class="single_post_wrapper">
        
         <div class="comment_wrapper">
            <div>
                <p><?= $post['comment_text']?></p>
                <p><?= $post['comment_time']?></p>
                <p><?= $postId?></p>
            </div>
        </div>
        
    </div>

    
    
    <?php
}
?>
<h2>Here add new comments *fix:</h2>
</div>
<?php
} catch (PDOException $ex) {
echo $ex;
}