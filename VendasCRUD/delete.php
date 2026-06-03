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
    "DELETE FROM vendas WHERE id=?"
);

$stmt->execute([$id]);

header(
    "Location:index.php?msg=Venda excluída com sucesso"
);

exit;
?>