<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexao.php';

$autores = $pdo->query("SELECT id, nome FROM autores ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo   = trim($_POST['titulo']);
    $genero   = trim($_POST['genero']);
    $preco    = $_POST['preco'];
    $autor_id = $_POST['autor_id'];

    if (empty($titulo) || empty($genero) || empty($preco) || empty($autor_id)) {
        $erro = 'Preencha todos os campos.';
    } else {
        $sql = "INSERT INTO mangas (titulo, genero, preco, autor_id) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $genero, $preco, $autor_id]);
        header('Location: index.php?msg=registrado');
        exit;
    }
}

$page_title = 'Novo Mangá';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="flex items-center space-x-4 mb-8">
    <a href="index.php" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Novo Mangá</h1>
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
            <label for="titulo" class="block text-sm font-semibold text-slate-700">Título</label>
            <input type="text" id="titulo" name="titulo" required placeholder="Ex: Naruto Vol. 1"
                   value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="space-y-1.5">
            <label for="genero" class="block text-sm font-semibold text-slate-700">Gênero</label>
            <input type="text" id="genero" name="genero" required placeholder="Ex: Shonen, Seinen, romance..."
                   value="<?= htmlspecialchars($_POST['genero'] ?? '') ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="space-y-1.5">
            <label for="preco" class="block text-sm font-semibold text-slate-700">Preço (R$)</label>
            <input type="number" id="preco" name="preco" required step="0.01" min="0" placeholder="0.00"
                   value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
        </div>

        <div class="space-y-1.5">
            <label for="autor_id" class="block text-sm font-semibold text-slate-700">Autor</label>
            <select id="autor_id" name="autor_id" required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all bg-white">
                <option value="">Selecione um autor</option>
                <?php foreach ($autores as $autor): ?>
                    <option value="<?= $autor['id'] ?>" <?= (isset($_POST['autor_id']) && $_POST['autor_id'] == $autor['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($autor['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (empty($autores)): ?>
                <p class="text-xs text-amber-600 mt-1">Nenhum autor cadastrado. <a href="../autoresCRUD/create.php" class="font-semibold underline">Cadastre um autor primeiro.</a></p>
            <?php endif; ?>
        </div>

        <div class="flex items-center space-x-3 pt-2">
            <button type="submit" class="px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:-translate-y-0.5">
                Salvar Mangá
            </button>
            <a href="index.php" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-all">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>