<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome            = trim($_POST['nome']);
    $nacionalidade   = trim($_POST['nacionalidade']);
    $data_nascimento = $_POST['data_nascimento'];

    if (empty($nome) || empty($nacionalidade) || empty($data_nascimento)) {
        $erro = 'Preencha todos os campos.';
    } else {
        $sql = "INSERT INTO autores (nome, nacionalidade, data_nascimento) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $nacionalidade, $data_nascimento]);
        header('Location: index.php?msg=Autor cadastrado com sucesso');
        exit;
    }
}

$page_title = 'Novo Autor';
require_once __DIR__ . '/../includes/header.php';
?>


<div class="flex items-center space-x-4 mb-8">
    <a href="index.php" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Novo Autor</h1>
        <p class="text-slate-500 text-sm mt-1">Preencha os dados para cadastrar</p>
    </div>
</div>


<?php if ($erro): ?>
    <div class="mb-6 flex items-center space-x-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">
        <svg class="h-5 w-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span><?= htmlspecialchars($erro) ?></span>
    </div>
<?php endif; ?>


<div class="max-w-xl bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <form method="POST" class="space-y-5">

        <div class="space-y-1.5">
            <label for="nome" class="block text-sm font-semibold text-slate-700">Nome</label>
            <input type="text" id="nome" name="nome" required placeholder="Nome completo do autor"
                   value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="space-y-1.5">
            <label for="nacionalidade" class="block text-sm font-semibold text-slate-700">Nacionalidade</label>
            <input type="text" id="nacionalidade" name="nacionalidade" required placeholder="Ex: Japonesa, Brasileira..."
                   value="<?= htmlspecialchars($_POST['nacionalidade'] ?? '') ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="space-y-1.5">
            <label for="data_nascimento" class="block text-sm font-semibold text-slate-700">Data de Nascimento</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required
                   value="<?= htmlspecialchars($_POST['data_nascimento'] ?? '') ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="flex items-center space-x-3 pt-2">
            <button type="submit" class="px-6 py-3 bg-violet-600 hover:bg-violet-500 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:-translate-y-0.5">
                Salvar Autor
            </button>
            <a href="index.php" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-all">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>