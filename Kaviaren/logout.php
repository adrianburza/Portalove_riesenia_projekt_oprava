<?php
session_start();

if (isset($_SESSION)) {
    session_destroy();
    header('Location: admin.php');
} else {
    echo "<p>No active session was found.</p>";
}