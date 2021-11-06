<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>
<title>create a post</title>
</head>

<body class="main">

    <header>
        <nav>
            <a href="/admin">Home</a>
            <a href="/profile">Profile</a>
            <a href="/logout">Log out</a>
        </nav>
    </header>

    <div class="post_wrapper">
        <form action="post" method="POST" onsubmit="return validate()" enctype="multipart/form-data">
        <h1>make a post</h1>
            <label for="your_message">Your message</label>
            <input type="text" placeholder="Write your message here" data-validate="str" name="message" autocomplete="off">            
            <button>Send</button>
        </form>
    </div>

    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_posts_feed.php');
    ?>

    <script src="../js/validator.js"></script>

</body>

</html>