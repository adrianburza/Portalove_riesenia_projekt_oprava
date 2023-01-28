<?php
include_once "DB.php";

use kaviaren\DB;
$db = new DB('localhost', 'kaviarendb', 'root', '');
session_start();

if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $display_name = $_POST['display_name'];

    if($db->updateMenu($id, $display_name)) {
        header("Location: update_menu_page.php");
    } else {
        echo "Menu could not be updated";
    }
} else {
    header("Location: update_menu_page.php");
}
