</head>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/webdev/kea-kb/css/app.css">
    <link rel="stylesheet" href="/webdev/kea-kb/css/post.css">
    <title>Sign up</title>
</head>

<body class="main">

    <header>
        <nav>
            <div class="logo">
                <a href="#"><img src="/webdev/kea-kb/images/logo-main-black-single.png" alt="logo" style="width: 60px;"></a>
            </div>
    </header>

    <div class="form_wrapper">

        <form action="/webdev/kea-kb/signup" method="POST" onsubmit="return validate()" enctype="multipart/form-data" class="login single_post_wrapper">

            <h1>Sign up</h1>
            <label for="first_name">First name</label>
            <input type="text" placeholder="Your first name" data-validate="str" name="first_name">
            <label for="last_name">Last name</label>
            <input type="text" placeholder="Your last name" data-validate="str" name="last_name">
            <label for="email">Email</label>
            <input type="text" placeholder="Email" data-validate="email" name="email">
            <label for="pass">Password</label>
            <sub>(Min 6 character with at least 1 lowecase letter, uppercase letter, number and special character)</sub>
            <input type="password" placeholder="Choose a good one" data-validate="pass" name="pass">
            <label for="con_pass">Confirm password</label>
            <input type="password" data-validate="con_pass" name="con_pass" placeholder="Confirm password">
            <button>Sign up</button>
            <div>
                <p>Already have an account? <a href="/webdev/kea-kb/login">login</a></p>
            </div>

        </form>

    </div>

    <script src="/webdev/kea-kb/js/validator.js"></script>

</body>

</html>