</head>

<body class="main">

    <header>
        <nav>
            <?php
            if ($_SESSION['user_role'] == 1) {
                echo '<a href="/webdev/kea-kb/users">Users</a>';
            }
            ?>
            <a href="/webdev/kea-kb/admin">Home</a>
            <a href="/webdev/kea-kb/admin">New post</a>
            <a href="/webdev/kea-kb/webdev/kea-kb/profile">Profile</a>
            <a href="/logout">Log out</a>
        </nav>
    </header>