<?php
require_once "../conexao.php";

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if(!$id){
    header("Location:index.php");
    exit;
}

$stmt = $pdo->prepare(
    "SELECT * FROM vendas WHERE id=?"
);

$stmt->execute([$id]);

$venda = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$venda){
    header("Location:index.php");
    exit;
}

$mangas = $pdo->query(
    "SELECT id,titulo FROM mangas ORDER BY titulo"
)->fetchAll(PDO::FETCH_ASSOC);

$erro = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $manga_id = $_POST['manga_id'];
    $quantidade = $_POST['quantidade'];
    $data_venda = $_POST['data_venda'];

    if(
        empty($manga_id) ||
        empty($quantidade) ||
        empty($data_venda)
    ){
        $erro = "Preencha todos os campos.";
    }
    else{

        $sql = "
        UPDATE vendas
        SET
            manga_id=?,
            quantidade=?,
            data_venda=?
        WHERE id=?
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $manga_id,
            $quantidade,
            $data_venda,
            $id
        ]);

        header(
            "Location:index.php?msg=Venda atualizada com sucesso"
        );
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Venda</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<h1>Editar Venda</h1>

<?php if($erro): ?>
<div class="msg erro">
<?= $erro ?>
</div>
<?php endif; ?>

<form method="POST">

<select name="manga_id">

<?php foreach($mangas as $manga): ?>

<option
value="<?= $manga['id'] ?>"
<?= ($manga['id'] == $venda['manga_id']) ? 'selected' : '' ?>>

<?= htmlspecialchars($manga['titulo']) ?>

</option>

<?php endforeach; ?>

</select>

<input
type="number"
name="quantidade"
min="1"
value="<?= $venda['quantidade'] ?>">

<input
type="date"
name="data_venda"
value="<?= $venda['data_venda'] ?>">

<button type="submit">
Atualizar
</button>

</form>

</div>

</body>
</html>