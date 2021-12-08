<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
?>
<!-- <title>create a post</title> -->
<!-- </head> -->

<!-- <body class="main"> -->

<!-- <header>
        <nav>
            <a href="/admin">Home</a>
            <a href="/profile">Profile</a>
            <a href="/logout">Log out</a>
        </nav>
    </header> -->

<div class="post_wrapper">
    <form action="/webdev/kea-kb/post" method="POST" onsubmit="return validate()" enctype="multipart/form-data" class="profile_form">
        <?php set_csrf(); ?>
        <h1>make a post</h1>
        <label for="your_message">Your message</label>
        <input type="text" placeholder="Write your message here" data-validate="str" name="message" autocomplete="off">

        <label for="screenshot">Add screenshot</label>
        <input type="file" name="screenshot">

        <button>Send</button>
    </form>
</div>

<div id="posts">
    <h2>My posts:</h2>
</div>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_posts_by_user.php');
?>

<script src="../js/validator.js"></script>

</body>

</html>