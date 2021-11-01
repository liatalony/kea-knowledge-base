<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>
<title>sign up</title>
</head>

<body>

    <div class="form_wrapper">

        <form action="signup" method="POST" onsubmit="return validate()" enctype="multipart/form-data">

            <h1>Sign up</h1>
            <label for="first_name">First name</label>
            <input type="text" placeholder="Your first name" data-validate="str" name="first_name">
            <label for="last_name">Last name</label>
            <input type="text" placeholder="Your last name" data-validate="str" name="last_name">
            <label for="email">Email</label>
            <input type="text" placeholder="Email" data-validate="email" name="email">
            <label for="pass">Password</label>
            <input type="password" placeholder="Between 6 to 8 characters" data-validate="pass" name="pass">
            <label for="con_pass">Confirm password</label>
            <input type="password" data-validate="con_pass" name="con_pass">
            <label for="age">Age</label>
            <input type="text" data-validate="age" name="age" maxlength="2">
            <label for="pic">Profile picture</label>
            <input type="file" data-validate="pic" name="pic">
            <button>Sign up</button>
            <div>
                <p>Already have an account? <a href="/login">login</a></p>
            </div>

        </form>

    </div>

    <script src="../js/validator.js"></script>

</body>

</html>