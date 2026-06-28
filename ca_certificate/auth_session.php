<?php
session_start();
header('Content-Type: application/json');
echo json_encode(['user' => isset($_SESSION['user']) ? $_SESSION['user'] : null]);
?>
