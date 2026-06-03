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

$sql = "SELECT * FROM autores WHERE id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$autor = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$autor){
    header("Location:index.php");
    exit;
}

$erro = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = trim($_POST['nome']);
    $nacionalidade = trim($_POST['nacionalidade']);
    $data_nascimento = $_POST['data_nascimento'];

    if(
        empty($nome) ||
        empty($nacionalidade) ||
        empty($data_nascimento)
    ){
        $erro = "Preencha todos os campos.";
    }else{

        $sql = "UPDATE autores SET

                nome=?,
                nacionalidade=?,
                data_nascimento=?

                WHERE id=?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $nome,
            $nacionalidade,
            $data_nascimento,
            $id
        ]);

        header(
            "Location:index.php?msg=Autor atualizado"
        );
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Autor</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<h1>Editar Autor</h1>

<?php if($erro): ?>
<div class="msg erro"><?= $erro ?></div>
<?php endif; ?>

<form method="POST">

<input
type="text"
name="nome"
value="<?= htmlspecialchars($autor['nome']) ?>">

<input
type="text"
name="nacionalidade"
value="<?= htmlspecialchars($autor['nacionalidade']) ?>">

<input
type="date"
name="data_nascimento"
value="<?= $autor['data_nascimento'] ?>">

<button type="submit">
Atualizar
</button>

</form>

</div>

</body>
</html>