<?php
require_once __DIR__ . "../includes/conexao.php";

$sql = "
SELECT
    v.id,
    v.quantidade,
    v.data_venda,
    m.titulo
FROM vendas v
INNER JOIN mangas m
ON v.manga_id = m.id
ORDER BY v.id DESC
";

$stmt = $pdo->query($sql);
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Vendas</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<div class="menu">
    <a href="../autores/index.php">Autores</a>
    <a href="../mangas/index.php">Mangás</a>
    <a href="../vendas/index.php">Vendas</a>
</div>

<h1>Gerenciamento de Vendas</h1>

<?php if(isset($_GET['msg'])): ?>
<div class="msg sucesso">
    <?= htmlspecialchars($_GET['msg']) ?>
</div>
<?php endif; ?>

<a href="create.php" class="btn btn-add">
    Nova Venda
</a>

<table>

<tr>
    <th>ID</th>
    <th>Mangá</th>
    <th>Quantidade</th>
    <th>Data da Venda</th>
    <th>Ações</th>
</tr>

<?php foreach($vendas as $venda): ?>

<tr>

<td><?= $venda['id'] ?></td>

<td><?= htmlspecialchars($venda['titulo']) ?></td>

<td><?= $venda['quantidade'] ?></td>

<td><?= date('d/m/Y', strtotime($venda['data_venda'])) ?></td>

<td>

<a
href="update.php?id=<?= $venda['id'] ?>"
class="btn btn-edit">
Editar
</a>

<a
href="delete.php?id=<?= $venda['id'] ?>"
class="btn btn-delete"
onclick="return confirm('Deseja excluir esta venda?')">
Excluir
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>