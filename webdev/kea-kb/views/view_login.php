<?php
session_start();
if (isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/admin');
    exit();
}
?>

</head>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/webdev/kea-kb/css/app.css">
    <link rel="stylesheet" href="/webdev/kea-kb/css/post.css">
    <title>login</title>
</head>

<body class="main">

    <header>
        <nav>
            <div class="logo">
                <a href="#"><img src="/webdev/kea-kb/images/logo-main-black-single.png" alt="logo" style="width: 60px;"></a>
            </div>
    </header>

    <body>
        <div class="form_wrapper">

            <form action="/webdev/kea-kb/login" method="POST" onsubmit="return validate()" class="login single_post_wrapper">

                <h1>Login</h1>
                <?php
                if (isset($_SESSION['error'])) {
                ?>
                    <sub><?= $_SESSION['error'] ?></sub>
                <?php
                    session_destroy();
                }
                ?>
                <label for="email">Email</label>
                <input type="text" placeholder="Email" data-validate="email" name="email">
                <label for="pass">Password</label>
                <input type="password" placeholder="Password" data-validate="pass" name="pass">
                <sub><a href="/webdev/kea-kb/get-password">Forgot password</a></sub>
                <button>Login</button>
                <div>
                    <p>Don't have an account? <a href="/webdev/kea-kb/signup">Sign-up</a></p>
                </div>

            </form>
        </div>
        <script src="/webdev/kea-kb/js/validator.js"></script>
    </body>

</html>