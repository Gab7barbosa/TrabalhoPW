<?php
include "conexao.php";
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('location: /pages/categorias/index.php');
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare(
        'SELECT id, senha FROM usuarios WHERE email = ?'
    );

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
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f4f4f4;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-container{
    width:100%;
    max-width:400px;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}

.login-container h1{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:5px;
}

.form-group input{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:5px;
    background:#007bff;
    color:white;
    cursor:pointer;
    font-size:16px;
}

button:hover{
    background:#0056b3;
}

.erro{
    background:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:5px;
    margin-bottom:15px;
    text-align:center;
}

</style>

</head>
<body>

<div class="login-container">

<h1>Login</h1>

<?php if(!empty($erro)): ?>
<div class="erro">
    <?= htmlspecialchars($erro) ?>
</div>
<?php endif; ?>

<form method="POST">

<div class="form-group">
    <label>Email</label>
    <input
        type="email"
        name="email"
        required
    >
</div>

<div class="form-group">
    <label>Senha</label>
    <input
        type="password"
        name="senha"
        required
    >
</div>

<button type="submit">
    Entrar
</button>

</form>

</div>

</body>
</html>