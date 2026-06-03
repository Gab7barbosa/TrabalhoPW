<?php
require_once "../conexao.php";

$autores = $pdo->query(
    "SELECT id,nome FROM autores ORDER BY nome"
)->fetchAll(PDO::FETCH_ASSOC);

$erro = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $titulo = trim($_POST['titulo']);
    $genero = trim($_POST['genero']);
    $preco = $_POST['preco'];
    $autor_id = $_POST['autor_id'];

    if(
        empty($titulo) ||
        empty($genero) ||
        empty($preco) ||
        empty($autor_id)
    ){
        $erro = "Preencha todos os campos.";
    }
    else{

        $sql = "
        INSERT INTO mangas
        (
            titulo,
            genero,
            preco,
            autor_id
        )
        VALUES
        (
            ?,?,?,?
        )
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $titulo,
            $genero,
            $preco,
            $autor_id
        ]);

        header(
            "Location:index.php?msg=Mangá cadastrado com sucesso"
        );
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Novo Mangá</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<h1>Cadastrar Mangá</h1>

<?php if($erro): ?>
<div class="msg erro"><?= $erro ?></div>
<?php endif; ?>

<form method="POST">

<input
type="text"
name="titulo"
placeholder="Título">

<input
type="text"
name="genero"
placeholder="Gênero">

<input
type="number"
step="0.01"
name="preco"
placeholder="Preço">

<select name="autor_id">

<option value="">
Selecione um autor
</option>

<?php foreach($autores as $autor): ?>

<option value="<?= $autor['id'] ?>">
<?= htmlspecialchars($autor['nome']) ?>
</option>

<?php endforeach; ?>

</select>

<button type="submit">
Salvar
</button>

</form>

</div>

</body>
</html>