<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/webdev/kea-kb/css/app.css">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Helvetica, sans-serif;
        }

        .container {
            display: block;
            width: max-content;
            text-align: center;
            margin: auto;
            margin-top: 7rem;
        }

        h1 {
            font-size: 10rem;
        }

        h2 {
            font-size: 2rem;
        }
    </style>
</head>

<header>
    <nav>
        <div class="logo">
            <a href="#"><img src="/webdev/kea-kb/images/logo-main-black-single.png" alt="logo" style="width: 60px;"></a>
        </div>
        <a href="/webdev/kea-kb/admin">Home</a>
        <?php
        if ($_SESSION['user_role'] == 1) {
            echo '<a href="/webdev/kea-kb/users">Users</a>';
        }
        ?>
        <a href="/webdev/kea-kb/feed">Feed</a>
        <a href="/webdev/kea-kb/post">New post</a>
        <a href="/webdev/kea-kb/profile">Profile</a>
        <a href="/webdev/kea-kb/logout">Log out</a>
    </nav>
</header>

<body>

    <div class="container">
        <h1>404</h1>
        <h2>This page could not be found</h2>
    </div>

</body>

</html>