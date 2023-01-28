<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');
session_start();

if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $from = $_POST['from'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if($db->updateEmail($id, $from, $email, $message)) {
        header("Location: update_email_page.php");
    } else {
        echo "Email could not be updated.";
    }
} else {
    header("Location: update_email_page.php");
}
