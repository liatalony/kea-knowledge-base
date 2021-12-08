<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}


try {
    $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare('SELECT * FROM users WHERE user_uuid = :user_uuid');
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /webdev/kea-kb/login');
        exit();
    }
    // echo "Hi {$user['first_name']} {$user['last_name']}";
} catch (PDOException $ex) {
    echo $ex;
}
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
?>
<title><?= "{$user['first_name']} {$user['last_name']}" ?></title>
<!-- <?php
        // require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_admin_top.php');
        // 
        ?> -->

<main>
    <h1 class="welcome"><?= out("Welcome {$user['first_name']} to KEA's Knowledge base") ?></h1>
    <?php
    try {
        $db_path = $_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db/users.db';
        $db = new PDO("sqlite:$db_path");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $q = $db->prepare('SELECT image_path FROM users WHERE user_uuid = :user_uuid');
        $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
        $q->execute();
        $img = $q->fetch();
    } catch (PDOException $ex) {
        echo $ex;
    }
    ?>
    </body>

    </html>