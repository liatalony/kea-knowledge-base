<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>
<title>Forgot password</title>
</head>

<body>
    <div class="form_wrapper">

        <form action="/send-password" method="POST" onsubmit="return validate()">

            <h1>Forgot Password</h1>

            <label for="email">Email</label>
            <input type="text" placeholder="Email" data-validate="email" name="email">
            <button>Get password</button>

        </form>
    </div>
    <script src="../js/validator.js"></script>
</body>

</html>