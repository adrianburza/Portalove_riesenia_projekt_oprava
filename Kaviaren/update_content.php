<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');
session_start();

if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $content = $_POST['content'];

    if ($db->updateContent($id, $content)) {
        header("Location: update_content_page.php");
    } else {
        echo "Content could not be updated.";
    }
} else {
    header("Location: update_content_page.php");
}