<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] === false) {
    header("Location: login_form.php");
    exit;
}

$contentDetails = $db->getContentDetails($_GET['id']);
?>

<style>
    body{
        font-family: Arial;
        font-size: 17px;
    }

    input {
        background-color: lightgray;
        border-radius: 3px;
        border: 2px solid black;
        padding: 3px;
    }

    textarea {
        background-color: lightgray;
        border-radius: 3px;
        border: 2px solid black;
    }

    .upd{
        font-family: Arial;
        color: white;
        background-color: grey;
        border-radius: 3px;
        border: 2px solid black;
        font-size: 15px;
    }
    .upd:hover{
        background-color: indianred;
        cursor: pointer;
    }
</style>

<body style="background: linear-gradient(45deg, lightsteelblue 50%,lightgray 50%)";>

<form action="update_content.php" method="post">
    Content:<br>
    <textarea name="content"><?php echo $contentDetails[0]['content']; ?></textarea><br>
    <input type="hidden" name="id" value="<?php echo $contentDetails[0]['id']; ?>"><br>
    <input class="upd" type="submit" name="submit" value="Update">
</form>