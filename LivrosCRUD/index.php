<?php
require_once "../conexao.php";

$sql = "
SELECT
    m.id,
    m.titulo,
    m.genero,
    m.preco,
    a.nome AS autor
FROM mangas m
INNER JOIN autores a
ON m.autor_id = a.id
ORDER BY m.id DESC
";

$stmt = $pdo->query($sql);
$mangas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Mangás</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<div class="menu">
    <a href="../autores/index.php">Autores</a>
    <a href="../mangas/index.php">Mangás</a>
    <a href="../vendas/index.php">Vendas</a>
</div>

<h1>Gerenciamento de Mangás</h1>

<?php if(isset($_GET['msg'])): ?>
<div class="msg sucesso">
    <?= htmlspecialchars($_GET['msg']) ?>
</div>
<?php endif; ?>

<a href="create.php" class="btn btn-add">
    Novo Mangá
</a>

<table>

<tr>
    <th>ID</th>
    <th>Título</th>
    <th>Gênero</th>
    <th>Preço</th>
    <th>Autor</th>
    <th>Ações</th>
</tr>

<?php foreach($mangas as $manga): ?>

<tr>
    <td><?= $manga['id'] ?></td>

    <td><?= htmlspecialchars($manga['titulo']) ?></td>

    <td><?= htmlspecialchars($manga['genero']) ?></td>

    <td>R$ <?= number_format($manga['preco'],2,",",".") ?></td>

    <td><?= htmlspecialchars($manga['autor']) ?></td>

    <td>

        <a
        href="update.php?id=<?= $manga['id'] ?>"
        class="btn btn-edit">
        Editar
        </a>

        <a
        href="delete.php?id=<?= $manga['id'] ?>"
        class="btn btn-delete"
        onclick="return confirm('Deseja excluir este mangá?')">
        Excluir
        </a>

    </td>
</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>