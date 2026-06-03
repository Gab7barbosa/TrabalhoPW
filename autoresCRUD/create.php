<?php
require_once "../conexao.php";

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

        $sql = "INSERT INTO autores
                (nome,nacionalidade,data_nascimento)
                VALUES (?,?,?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $nome,
            $nacionalidade,
            $data_nascimento
        ]);

        header(
            "Location:index.php?msg=Autor cadastrado com sucesso"
        );
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Novo Autor</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

<h1>Cadastrar Autor</h1>

<?php if($erro): ?>
<div class="msg erro"><?= $erro ?></div>
<?php endif; ?>

<form method="POST">

<input
type="text"
name="nome"
placeholder="Nome">

<input
type="text"
name="nacionalidade"
placeholder="Nacionalidade">

<input
type="date"
name="data_nascimento">

<button type="submit">
Salvar
</button>

</form>

</div>

</body>
</html>