<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/router.php');

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
    $q = $db->prepare('SELECT * FROM posts
                    INNER JOIN users
                    ON posts.user_uuid = users.user_uuid
                    WHERE users.user_uuid = :user_uuid
                    ORDER BY post_time DESC 
                    ');
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->execute();
    $posts = $q->fetchAll();
?>

    <div id="posts">

        <?php
        foreach ($posts as $post) {
        ?>
            <div class="single_post_wrapper">
                <div class="post_owner">
                    <img src="<?= $post['image_path'] ?>" alt="profile_pic" class="feed_profile">
                    <div>
                        <h4><?= out($post['first_name'] . ' ' . $post['last_name']) ?></h4>
                        <sub><?= $post['post_time'] ?></sub>
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
                <div class="comment_wrapper">
                    <hr>
                    <form action="/webdev/kea-kb/comment" method="POST" onsubmit="return validate()" enctype="multipart/form-data" class="profile_form">
                        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                        <input type="hidden" name="postId" value="<?= $post['post_id'] ?>" />
                        <input type="text" placeholder="Write your comment here" data-validate="str" name="message" autocomplete="off">
                        <button>Send</button>
                    </form>
                    <a href="/webdev/kea-kb/post/<?= $post['post_id'] ?>">See post</a>
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
