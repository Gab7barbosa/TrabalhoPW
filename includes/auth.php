<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    // Dynamically resolve relative path to login.php
    $path_prefix = '';
    if (!file_exists('login.php') && file_exists('../login.php')) {
        $path_prefix = '../';
    }
    header('Location: ' . $path_prefix . 'login.php');
    exit();
}
?>
