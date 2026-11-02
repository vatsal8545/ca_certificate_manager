<?php
session_start();
// Simple auth check - redirect to home page if user not logged in
if (!isset($_SESSION['user'])) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    if (strpos($scriptName, '/admin/') !== false || preg_match('#/admin$#', $scriptName)) {
        header('Location: ../home.php');
    } else {
        header('Location: home.php');
    }
    exit;
}
?>

