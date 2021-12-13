<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/router.php');


// get the post id from url:
$postId = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$_SESSION['current_page'] = "post/$postId";
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}
?>

<div class="single_post_wrapper">

    <?php
    try {
        $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
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
                    WHERE comments.post_id = :post_id
                    ORDER BY comment_time ASC');
        $q->bindValue(':post_id', $postId);
        $q->execute();
        $comments = $q->fetchAll();
    ?>
        <div class="post_owner">
            <img src="<?= $post['image_path'] ?>" alt="profile_pic" class="feed_profile">
            <div>
                <h4><?= out($post['first_name'] . ' ' . $post['last_name']) ?></h4>
                <sub><?= date("F j, Y, g:i a", strtotime($post['post_time'])) ?></sub>
            </div>
        </div>
        <h4 class="post_text"><?= out($post['post_text']) ?></h4>
        <?php
        if ($post['post_image_path'] != "none") {
        ?>
            <div class="post_img">
                <img src="<?= $post['post_image_path'] ?>" alt="screenshot">
            </div>
        <?php
        }
        ?>

        <hr>
        <h4>Comments</h4>
        <hr>
        <?php
        foreach ($comments as $comment) {
        ?>
            <div class="comment_wrapper">
                <div class="pic_text">
                    <img src="<?= $comment['image_path'] ?>" alt="profile_pic" class="feed_profile">
                    <div class="single_comment_wrapper">
                        <div>
                            <div class="post_owner">
                                <div>
                                    <h5><?= out($comment['first_name'] . ' ' . $comment['last_name']) ?></h5>
                                </div>
                            </div>
                            <p class="comment_text"><?= out($comment['comment_text']) ?></p>

                        </div>
                    </div>
                </div>
                <sub><?= $comment['comment_time'] ?></sub>
            </div>

        <?php
        }
        ?>
        <br>
        <div class="comment_wrapper">
            <hr>
            <form action="/webdev/kea-kb/comment" method="POST" onsubmit="return validate()" enctype="multipart/form-data" class="profile_form">
                <?php set_csrf(); ?>
                <input type="hidden" name="postId" value="<?= $post['post_id'] ?>" />
                <input type="text" placeholder="Write your comment here" data-validate="str" name="message" autocomplete="off">
                <button>Send</button>
            </form>
        </div>

</div>
<?php
    } catch (PDOException $ex) {
        echo $ex;
    }
