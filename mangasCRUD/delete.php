<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("DELETE FROM mangas WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php?msg=excluido);
exit;
?>