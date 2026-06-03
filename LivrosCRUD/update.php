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
    "SELECT * FROM mangas WHERE id=?"
);

$stmt->execute([$id]);

$manga = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$manga){
    header("Location:index.php");
    exit;
}

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
        UPDATE mangas
        SET
            titulo=?,
            genero=?,
            preco=?,
            autor_id=?
        WHERE id=?
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $titulo,
            $genero,
            $preco,
            $autor_id,
            $id
        ]);

        header(
            "Location:index.php?msg=Mangá atualizado com sucesso"
        );
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Mangá</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<h1>Editar Mangá</h1>

<?php if($erro): ?>
<div class="msg erro">
<?= $erro ?>
</div>
<?php endif; ?>

<form method="POST">

<input
type="text"
name="titulo"
value="<?= htmlspecialchars($manga['titulo']) ?>">

<input
type="text"
name="genero"
value="<?= htmlspecialchars($manga['genero']) ?>">

<input
type="number"
step="0.01"
name="preco"
value="<?= $manga['preco'] ?>">

<select name="autor_id">

<?php foreach($autores as $autor): ?>

<option
value="<?= $autor['id'] ?>"
<?= ($autor['id'] == $manga['autor_id']) ? 'selected' : '' ?>>

<?= htmlspecialchars($autor['nome']) ?>

</option>

<?php endforeach; ?>

</select>

<button type="submit">
Atualizar
</button>

</form>

</div>

</body>
</html>