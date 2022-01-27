<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/router.php');

$_SESSION['current_page'] = "feed";

if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

try {
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
        <?php set_csrf(); ?>

        <?php foreach ($posts as $post) {
        ?>
            <div class="single_post_wrapper">
                <div class="post_owner">
                    <div class="feed_profile" style="background-image: url('<?= $post['image_path'] ?>'); background-repeat:no-repeat; background-size:cover; background-position:center;"></div>
                    <div>
                        <h4><?= out($post['first_name'] . ' ' . $post['last_name']) ?></h4>
                        <sub><?= date("F j, Y, g:i a", strtotime($post['post_time'])); ?></sub>
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
                <a href="/webdev/kea-kb/post/<?= $post['post_id'] ?>" class="comment_link">See comments</a>
                <div class="comment_wrapper">
                    <hr>

                    <?php
                    try {
                        $q = $db->prepare('SELECT *
                                    FROM comments
                                    INNER JOIN users
                                    ON comments.user_uuid = users.user_uuid
                                    WHERE comments.post_id = :post_id
                                    ORDER BY comment_time DESC
                                    LIMIT 1');
                        $q->bindValue(':post_id', $post['post_id']);
                        $q->execute();
                        $comment = $q->fetch();
                    } catch (PDOException $ex) {
                        echo $ex->getMessage();
                    }

                    if ($comment) {
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


                    <form action="/webdev/kea-kb/comment" method="POST" onsubmit="return validate()" enctype="multipart/form-data" class="profile_form">
                        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                        <input type="hidden" name="postId" value="<?= $post['post_id'] ?>" />
                        <input type="text" placeholder="Write your comment here" data-validate="str" name="message" autocomplete="off">
                        <button>Send</button>
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
