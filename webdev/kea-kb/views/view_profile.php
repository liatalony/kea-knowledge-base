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
<title><?= "{$user['first_name']}'s profile" ?></title>
<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_admin_top.php');
// 
?>

<main>
    <h1 class="welcome">My profile</h1>
    <div class="profile_page">
        <div class="form_container">
            <?php
            if ($_SESSION['user_role'] == 2) {

            ?>
                <form action="/webdev/kea-kb/profile-pic" method="POST" class="profile_form" enctype="multipart/form-data">
                    <div class="img" <?php if ($user['image_path'] == 'NULL') {
                                            echo 'class="hidden"';
                                        } ?>>
                        <img src="<?= $user['image_path'] ?>" alt="profile_picture" class="profile_pic">
                    </div>
                    <label for="pic">Profile picture</label>
                    <input type="file" name="pic" data-validate="pic">
                    <button type="sumbit">Set profile_picture</button>
                </form>
                <form action="/webdev/kea-kb/deactivate" method="POST" class="profile_form">
                    <button class="deactivate">Deactivate account</button>
                </form>
        </div>
        <form action="/webdev/kea-kb/profile" method="POST" onsubmit="return validate()" class="profile_form" enctype="multipart/form-data">

            <label for="first_name">First name</label>
            <input type="text" placeholder="Your first name" data-validate="str" name="first_name" value="<?= $user['first_name'] ?>">
            <label for="last_name">Last name</label>
            <input type="text" placeholder="Your last name" data-validate="str" name="last_name" value="<?= $user['last_name'] ?>">
            <label for=" email">Email</label>
            <input type="text" placeholder="Email" data-validate="email" name="email" value="<?= $user['email'] ?>">
            <label for=" pass">Password</label>
            <input type="password" placeholder="Between 6 to 8 characters" data-validate="pass" name="pass">
            <label for="con_pass">Confirm password</label>
            <input type="password" data-validate="con_pass" name="con_pass" placeholder="confirm password">
            <button type="sumbit">Save</button>
        </form>
    <?php
            }
            if ($_SESSION['user_role'] == 1) {
    ?>
        <form action="/webdev/kea-kb/profile" method="POST" onsubmit="return validate()" class="profile_form" enctype="multipart/form-data">

            <label for=" pass">Password</label>
            <input type="password" placeholder="Between 6 to 8 characters" data-validate="pass" name="pass">
            <label for="con_pass">Confirm password</label>
            <input type="password" data-validate="con_pass" name="con_pass" placeholder="confirm password">
            <button type="sumbit">Save</button>
        </form>
    <?php
            }
    ?>
    </div>
</main>
<script src="../js/validator.js"></script>
</body>

</html>