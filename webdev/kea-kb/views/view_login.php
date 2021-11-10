<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
?>
<title>login</title>
</head>

<body>
    <div class="form_wrapper">

        <form action="/webdev/kea-kb/login" method="POST" onsubmit="return validate()" class="login">

            <h1>Login</h1>

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
    <script src="../js/validator.js"></script>
</body>

</html>