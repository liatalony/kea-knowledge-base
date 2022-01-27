<?php
session_start();
if (!isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/login');
    exit();
}

if ($_SESSION['user_role'] != 1) {
    header('Location: /webdev/kea-kb/404');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/views/view_top.php');
?>
<title>Users</title>

<main>
    <h1>Users</h1>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

    try {


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $q = $db->prepare('SELECT * FROM users
                            WHERE active=1
                            ORDER BY first_name asc');
        $q->execute();
        $users = $q->fetchAll();
        echo '<div id="users">';
        foreach ($users as $user) {
            unset($user['user_password']);
            unset($user['salt']);
    ?>
            <div class="user">
                <div class="bold">ID: </div>
                <div> <?= $user['user_uuid'] ?></div>
                <div class="bold">NAME: </div>
                <div><?= $user['first_name'] ?></div>
                <div class="bold">LAST NAME: </div>
                <div><?= $user['last_name'] ?></div>
                <div class="bold">EMAIL: </div>
                <div><?= $user['email'] ?></div>
                <button onclick="delete_user('<?= $user['user_uuid'] ?>')">Delete user</button>
            </div>
    <?php
        }
        echo '</div>';
    } catch (PDOException $ex) {
        echo $ex;
    }
    ?>
</main>

<script>
    async function delete_user(user_id) {
        let div_user = event.target.parentNode
        console.log(user_id);
        let conn = await fetch(`/webdev/kea-kb/users/delete/${user_id}`, {
            "method": "POST"
        })
        if (!conn.ok) {
            alert("upps...");
            return
        }
        window.location.href = `/webdev/kea-kb/sending-email/${user_id}`;
        // SEND EMAIL TO USER
        let data = await conn.text()
        console.log(data)
        div_user.remove()
    }
</script>
</body>

</html>