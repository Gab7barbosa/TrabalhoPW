<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/conexao.php';

$total_mangas  = $pdo->query("SELECT COUNT(*) FROM mangas")->fetchColumn();
$total_autores = $pdo->query("SELECT COUNT(*) FROM autores")->fetchColumn();
$total_vendas  = $pdo->query("SELECT COUNT(*) FROM vendas")->fetchColumn();
$total_receita = $pdo->query("SELECT COALESCE(SUM(v.quantidade * m.preco), 0) FROM vendas v INNER JOIN mangas m ON v.manga_id = m.id")->fetchColumn();

$recent_vendas = $pdo->query("
    SELECT v.id, v.quantidade, v.data_venda, m.titulo, m.preco,
           (v.quantidade * m.preco) AS total
    FROM vendas v
    INNER JOIN mangas m ON v.manga_id = m.id
    ORDER BY v.id DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$top_mangas = $pdo->query("
    SELECT m.titulo, SUM(v.quantidade) AS total_vendido
    FROM vendas v
    INNER JOIN mangas m ON v.manga_id = m.id
    GROUP BY m.id, m.titulo
    ORDER BY total_vendido DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Dashboard</h1>
        <p class="text-slate-500 text-sm mt-1">Visão geral do sistema MangaStore</p>
    </div>
    <div class="text-sm text-slate-400">
        <?= date('d/m/Y') ?>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
    <a href="mangasCRUD/index.php" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-brand-200 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-indigo-500 bg-indigo-50 px-2 py-1 rounded-full">Mangás</span>
        </div>
        <p class="text-3xl font-extrabold text-slate-800"><?= number_format($total_mangas) ?></p>
        <p class="text-sm text-slate-500 mt-1">Títulos cadastrados</p>
    </a>

    <!-- Autores Card -->
    <a href="autoresCRUD/index.php" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-brand-200 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-violet-50 flex items-center justify-center group-hover:bg-violet-100 transition-colors">
                <svg class="h-6 w-6 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-violet-500 bg-violet-50 px-2 py-1 rounded-full">Autores</span>
        </div>
        <p class="text-3xl font-extrabold text-slate-800"><?= number_format($total_autores) ?></p>
        <p class="text-sm text-slate-500 mt-1">Autores cadastrados</p>
    </a>

    <!-- Vendas Card -->
    <a href="VendasCRUD/index.php" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-brand-200 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-full">Vendas</span>
        </div>
        <p class="text-3xl font-extrabold text-slate-800"><?= number_format($total_vendas) ?></p>
        <p class="text-sm text-slate-500 mt-1">Vendas registradas</p>
    </a>

    <div class="bg-gradient-to-br from-brand-600 to-indigo-700 rounded-2xl p-6 shadow-lg shadow-brand-600/20">
        <div class="flex items-center justify-between mb-4">
            <div class="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-white/70 bg-white/10 px-2 py-1 rounded-full">Receita</span>
        </div>
        <p class="text-3xl font-extrabold text-white">R$ <?= number_format($total_receita, 2, ',', '.') ?></p>
        <p class="text-sm text-white/70 mt-1">Faturamento total</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Vendas Recentes</h2>
            <a href="VendasCRUD/index.php" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">Ver todas →</a>
        </div>
        <div class="divide-y divide-slate-50">
            <?php if (empty($recent_vendas)): ?>
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Nenhuma venda registrada ainda.</div>
            <?php else: ?>
                <?php foreach ($recent_vendas as $v): ?>
                    <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition-colors">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="h-9 w-9 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-700 truncate"><?= htmlspecialchars($v['titulo']) ?></p>
                                <p class="text-xs text-slate-400"><?= date('d/m/Y', strtotime($v['data_venda'])) ?> · <?= $v['quantidade'] ?> un.</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-emerald-600 ml-4 shrink-0">R$ <?= number_format($v['total'], 2, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Mangás Mais Vendidos</h2>
            <a href="mangasCRUD/index.php" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">Ver todos →</a>
        </div>
        <div class="px-6 py-4 space-y-4">
            <?php if (empty($top_mangas)): ?>
                <div class="py-8 text-center text-slate-400 text-sm">Nenhuma venda registrada ainda.</div>
            <?php else: ?>
                <?php
                $max = $top_mangas[0]['total_vendido'] ?? 1;
                $colors = ['bg-indigo-500', 'bg-violet-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500'];
                foreach ($top_mangas as $i => $manga):
                    $pct   = $max > 0 ? round(($manga['total_vendido'] / $max) * 100) : 0;
                    $color = $colors[$i % count($colors)];
                ?>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-slate-700 truncate max-w-[200px]"><?= htmlspecialchars($manga['titulo']) ?></span>
                            <span class="text-xs font-bold text-slate-500 ml-2"><?= $manga['total_vendido'] ?> un.</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-2 <?= $color ?> rounded-full transition-all duration-500" style="width: <?= $pct ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <h2 class="font-bold text-slate-800 mb-4">Ações Rápidas</h2>
    <div class="flex flex-wrap gap-3">
        <a href="mangasCRUD/create.php" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-brand-600/30 hover:-translate-y-0.5">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Novo Mangá</span>
        </a>
        <a href="autoresCRUD/create.php" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-violet-600 hover:bg-violet-500 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-violet-600/30 hover:-translate-y-0.5">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Novo Autor</span>
        </a>
        <a href="VendasCRUD/create.php" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-emerald-600/30 hover:-translate-y-0.5">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Nova Venda</span>
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
