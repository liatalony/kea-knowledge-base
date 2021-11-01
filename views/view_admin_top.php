</head>

<body class="main">

    <header>
        <nav>
            <?php
            if ($_SESSION['user_role'] == 1) {
                echo '<a href="/users">Users</a>';
            }
            ?>
            <a href="/admin">Home</a>
            <a href="/profile">Profile</a>
            <a href="/logout">Log out</a>
        </nav>
    </header>