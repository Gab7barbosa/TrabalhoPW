<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('location:  /pages/categorias/index.php');
    exit();
}

require_once __DIR__ . '/config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare('SELECT id, senha FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        header('location: /pages/categorias/index.php');
        exit();
    } else {
        $erro = 'Email ou senha inválidos.';
    }
}

?>