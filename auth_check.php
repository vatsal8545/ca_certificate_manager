<?php
session_start();
// Simple auth check - redirect to login if user not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
