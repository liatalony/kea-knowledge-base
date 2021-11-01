<?php
session_start();
session_destroy();
if (isset($_SESSION['user_uuid'])) {
    header('Location: /admin');
    exit();
}
header('Location: /login');
