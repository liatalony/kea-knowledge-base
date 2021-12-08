<?php
session_start();
if (isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/admin');
    exit();
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
?>
<title>login</title>
</head>

<body>
    <div class="form_wrapper">

        <form action="/webdev/kea-kb/login" method="POST" onsubmit="return validate()" class="login">

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