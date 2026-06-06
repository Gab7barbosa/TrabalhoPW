<?php
// All PHP logic BEFORE any HTML output
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM vendas WHERE id = ?");
$stmt->execute([$id]);
$venda = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$venda) {
    header('Location: index.php');
    exit;
}

$mangas = $pdo->query("SELECT id, titulo FROM mangas ORDER BY titulo")->fetchAll(PDO::FETCH_ASSOC);

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manga_id   = $_POST['manga_id'];
    $quantidade = $_POST['quantidade'];
    $data_venda = $_POST['data_venda'];

    if (empty($manga_id) || empty($quantidade) || empty($data_venda)) {
        $erro = 'Preencha todos os campos.';
    } else {
        $sql = "UPDATE vendas SET manga_id = ?, quantidade = ?, data_venda = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$manga_id, $quantidade, $data_venda, $id]);
        header('Location: index.php?msg=Venda atualizada com sucesso');
        exit;
    }
}

$form = [
    'manga_id'   => $_POST['manga_id']   ?? $venda['manga_id'],
    'quantidade' => $_POST['quantidade'] ?? $venda['quantidade'],
    'data_venda' => $_POST['data_venda'] ?? $venda['data_venda'],
];

$page_title = 'Editar Venda';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Page Header -->
<div class="flex items-center space-x-4 mb-8">
    <a href="index.php" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Editar Venda</h1>
        <p class="text-slate-500 text-sm mt-1">#<?= $venda['id'] ?> · <?= date('d/m/Y', strtotime($venda['data_venda'])) ?></p>
    </div>
</div>

<!-- Error -->
<?php if ($erro): ?>
    <div class="mb-6 flex items-center space-x-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">
        <svg class="h-5 w-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span><?= htmlspecialchars($erro) ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="max-w-xl bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <form method="POST" class="space-y-5">

        <div class="space-y-1.5">
            <label for="manga_id" class="block text-sm font-semibold text-slate-700">Mangá</label>
            <select id="manga_id" name="manga_id" required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all bg-white">
                <option value="">Selecione um mangá</option>
                <?php foreach ($mangas as $manga): ?>
                    <option value="<?= $manga['id'] ?>" <?= ($form['manga_id'] == $manga['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($manga['titulo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="space-y-1.5">
            <label for="quantidade" class="block text-sm font-semibold text-slate-700">Quantidade</label>
            <input type="number" id="quantidade" name="quantidade" required min="1"
                   value="<?= htmlspecialchars($form['quantidade']) ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="space-y-1.5">
            <label for="data_venda" class="block text-sm font-semibold text-slate-700">Data da Venda</label>
            <input type="date" id="data_venda" name="data_venda" required
                   value="<?= htmlspecialchars($form['data_venda']) ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="flex items-center space-x-3 pt-2">
            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:-translate-y-0.5">
                Atualizar Venda
            </button>
            <a href="index.php" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-all">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>