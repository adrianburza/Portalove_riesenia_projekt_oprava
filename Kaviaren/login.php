<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = $db->login($username, $password);

    if($login) {
        session_start();
        $_SESSION['is_admin'] = true;
        header('Location: admin.php');
    } else {
        header('Location: admin.php');
    }
} else {
    header('Location: admin.php');
}


