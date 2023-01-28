<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');
session_start();

if(isset($_GET['id'])) {
    $delete = $db->deleteEmail($_GET['id']);
    if($delete) {
        header("Location: update_email_page.php");
    } else {
        echo "FATAL ERROR: Email can not be removed.";
    }
} else {
    header("Location: update_email_page.php");
}


