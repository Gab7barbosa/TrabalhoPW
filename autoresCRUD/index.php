<?php
include "conexao.php";

$stmt = $pdo -> query('SELECT * FROM autores ORDER BY id DESC');
$autores= $stmt ->fetchALL();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>painel de controle</title>
</head>
<body>
   <h2>gestão de autores</h2>
   <h2>gestão de livros</h2>
   <h2>funcionarios</h2>
</html>