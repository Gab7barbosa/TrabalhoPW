<?php
require_once "../conexao.php";

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
        INSERT INTO vendas
        (
            manga_id,
            quantidade,
            data_venda
        )
        VALUES
        (
            ?,?,?
        )
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $manga_id,
            $quantidade,
            $data_venda
        ]);

        header(
            "Location:index.php?msg=Venda cadastrada com sucesso"
        );
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Nova Venda</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<h1>Cadastrar Venda</h1>

<?php if($erro): ?>
<div class="msg erro">
<?= $erro ?>
</div>
<?php endif; ?>

<form method="POST">

<select name="manga_id">

<option value="">
Selecione um mangá
</option>

<?php foreach($mangas as $manga): ?>

<option value="<?= $manga['id'] ?>">
<?= htmlspecialchars($manga['titulo']) ?>
</option>

<?php endforeach; ?>

</select>

<input
type="number"
name="quant