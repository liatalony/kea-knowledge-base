<?php
session_start();
session_destroy();
if (isset($_SESSION['user_uuid'])) {
    header('Location: /webdev/kea-kb/admin');
    exit();
}
header('Location: /webdev/kea-kb/login');
