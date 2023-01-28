<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');
session_start();

if (isset($_POST['submit'])) {
    $insert = $db->insertCafe(
        $_POST['sys_name'],
        $_POST['display_name'],
        $_POST['image'],
        $_POST['size_S'],
        $_POST['size_M'],
        $_POST['size_L'],
        $_POST['cafeType']
    );

    if ($insert) {
        header('Location: update_cafe_menu_page.php');
    } else {
        echo "FATAL ERROR: Cafe can not be inserted.";
    }
} else {
    header('Location: update_cafe_menu_page.php');
}
?>

