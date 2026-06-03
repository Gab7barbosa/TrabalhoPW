<?php
require_once "../conexao.php";

$stmt = $pdo->query("SELECT * FROM autores ORDER BY id DESC");
$autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Autores</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<div class="menu">
    <a href="../autores/index.php">Autores</a>
    <a href="../mangas/index.php">Mangás</a>
    <a href="../vendas/index.php">Vendas</a>
</div>

<h1>Autores</h1>

<?php if(isset($_GET['msg'])): ?>

<div class="msg sucesso">
    <?= htmlspecialchars($_GET['msg']) ?>
</div>

<?php endif; ?>

<a href="create.php" class="btn btn-add">
    Novo Autor
</a>

<table>

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Nacionalidade</th>
    <th>Data Nascimento</th>
</tr>

<?php foreach($autores as $autor): ?>

<tr>

<td><?= $autor['id'] ?></td>

<td><?= htmlspecialchars($autor['nome']) ?></td>

<td><?= htmlspecialchars($autor['nacionalidade']) ?></td>

<td><?= $autor['data_nascimento'] ?></td>

<td>

<a class="btn btn-edit"
href="update.php?id=<?= $autor['id'] ?>">
Editar
</a>

<a class="btn btn-delete"
onclick="return confirm('Deseja excluir?')"
href="delete.php?id=<?= $autor['id'] ?>">
Excluir
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>