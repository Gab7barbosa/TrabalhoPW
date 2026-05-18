<?php
require_once 'conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $país = trim($_POST['país'] ?? '');
    $nascimento = trim($_POST['DTnascimento'] ?? '');

   
    if (!empty($nome) && !empty($email)) {
        $sql = "INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone
        ]);
        
        // Redireciona de volta para a listagem
        header('Location: index.php');
        exit;
    } else {
        $erro = "Por favor, preencha os campos obrigatórios (Nome e E-mail).";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Cliente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .back-link { margin-left: 10px; text-decoration: none; color: #555; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

    <h2>Novo Cliente</h2>

    <?php if (!empty($erro)): ?>
        <p class="error"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST" action="criar.php">
        <div class="form-group">
            <label for="nome">Nome *</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        
        <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone">
        </div>
        
        <button type="submit">Salvar Cliente</button>
        <a href="index.php" class="back-link">Cancelar</a>
    </form>

</body>
</html>