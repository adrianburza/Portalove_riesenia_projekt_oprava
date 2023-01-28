<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');
session_start();

if(isset($_POST['submit'])) {
    $insert = $db->insertEmail(
        $_POST['from'],
        $_POST['email'],
        $_POST['message']
    );

    if($insert) {
        header("Location: index.php");
    } else {
        echo "FATAL ERROR!!!!";
    }
} else {
    header("Location: index.php");
}