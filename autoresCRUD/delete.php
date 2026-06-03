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

$sql = "DELETE FROM autores WHERE id=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$id]);

header(
    "Location:index.php?msg=Autor excluído com sucesso"
);

exit;
?>