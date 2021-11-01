<?php
echo strlen($user_uuid);
if (strlen($user_uuid) != 32) {
    header('Location: /login');
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');

?>
<title>Forgot password</title>
</head>

<body>
    <div class="form_wrapper">

        <form action="/update-password" method="POST" onsubmit="return validate()">

            <h1>Reset Password</h1>
            <input type="hidden" value="<?= $user_uuid ?>" name="user_uuid">
            <label for="pass">New Password</label>
            <input type="password" placeholder="Between 6 to 8 characters" data-validate="pass" name="pass">
            <label for="con_pass">Confirm password</label>
            <input type="password" data-validate="con_pass" name="con_pass">
            <button>Change password</button>

        </form>
    </div>
    <script src="../js/validator.js"></script>
</body>

</html>