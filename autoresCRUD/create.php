<?php
include "conexao.php";

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    if ($action === 'create') {
        $nome     = trim($_POST['nome']    ?? '');
        $país    = trim($_POST['país']   ?? '');
        $nascimento = trim($_POST['DTnascimento'] ?? '');
 
        if (!$nome)                      $errors[] = 'Nome é obrigatório.';
 
        if (!$errors) {
            $stmt = $db->prepare("INSERT INTO autores (nome, país, nascimento) VALUES (:n,:e,:t)");
            $stmt->bindValue(':n', $nome);
            $stmt->bindValue(':e', $pais);
            $stmt->bindValue(':t', $nascimento ?: null);
            if ($stmt->execute()) {
                redirect('index.php?success=criado');
            } else {
                $errors[] = 'E-mail já cadastrado.';
            }
        }
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro</title>
</head>
<body>
    <h1>ola</h1>
</body>
</html>