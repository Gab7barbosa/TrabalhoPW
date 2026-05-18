<?php
include "conexao.php";
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('location:  /pages/categorias/index.php');
    exit();
}

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tela de login</title>
</head>
<body>
     <form action="" method="post">
        <label for="email">email:</label><br>
        <input type="text" id="email" name="email"><br>
        <label for="senha">sua senha:</label><br>
        <input type="int" id="senha" name="sen">
    </form>
</body>
</html>