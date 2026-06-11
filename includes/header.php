<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/conexao.php';

$root_prefix = '';
if (!file_exists('login.php') && file_exists('../login.php')) {
    $root_prefix = '../';
}

$current_page = $_SERVER['SCRIPT_NAME'];
$is_dashboard = (strpos($current_page, 'index.php') !== false && strpos($current_page, 'CRUD') === false);
$is_mangas = (strpos($current_page, 'LivrosCRUD') !== false);
$is_autores = (strpos($current_page, 'autoresCRUD') !== false);
$is_vendas = (strpos($current_page, 'VendasCRUD') !== false);
?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' | MangaStore' : 'MangaStore' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            500: '#ffaf64',
                            600: 'rgb(252, 153, 24)',
                            700: '#fda500',
                            800: '#a37130',
                            900: '#814f2e',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="h-full flex flex-col md:flex-row overflow-hidden">

    <div class="md:hidden flex items-center justify-between bg-slate-950 text-white p-4 z-20 shadow-md">
        <div class="flex items-center space-x-2">
            <span class="text-xl">📖</span>
            <span class="font-bold tracking-wider text-lg">MangaStore</span>
        </div>
        <button id="mobile-menu-btn" class="p-2 focus:outline-none focus:ring-2 focus:ring-brand-500 rounded">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 transition-opacity duration-300 md:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-slate-950 text-slate-300 transform -translate-x-full transition-transform duration-300 ease-in-out z-40 flex flex-col justify-between shadow-2xl md:relative md:translate-x-0 md:z-10">
        <div>
            <div class="h-20 flex items-center px-6 bg-slate-900 border-b border-slate-800">
                <a href="<?= $root_prefix ?>index.php" class="flex items-center space-x-3 group">
                    <span class="text-3xl transform group-hover:scale-110 transition-transform duration-200">📖</span>
                    <span class="font-extrabold text-white text-xl tracking-wider group-hover:text-brand-400 transition-colors">MangaStore</span>
                </a>
            </div>

            <nav class="mt-6 px-4 space-y-2">

                <a href="<?= $root_prefix ?>index.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group <?= $is_dashboard ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'hover:bg-slate-900 hover:text-white' ?>">
                    <svg class="h-5 w-5 <?= $is_dashboard ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- Mangás -->
                <a href="<?= $root_prefix ?>mangasCRUD/index.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group <?= $is_mangas ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'hover:bg-slate-900 hover:text-white' ?>">
                    <svg class="h-5 w-5 <?= $is_mangas ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="font-medium">Mangás</span>
                </a>

                <!-- Autores -->
                <a href="<?= $root_prefix ?>autoresCRUD/index.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group <?= $is_autores ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'hover:bg-slate-900 hover:text-white' ?>">
                    <svg class="h-5 w-5 <?= $is_autores ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium">Autores</span>
                </a>

                <!-- Vendas -->
                <a href="<?= $root_prefix ?>VendasCRUD/index.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group <?= $is_vendas ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'hover:bg-slate-900 hover:text-white' ?>">
                    <svg class="h-5 w-5 <?= $is_vendas ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">Vendas</span>
                </a>
            </nav>
        </div>

        <div class="p-4 bg-slate-900 border-t border-slate-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="h-9 w-9 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        AD
                    </div>
                    <div class="text-sm truncate">
                        <p class="font-semibold text-white truncate">Administrador</p>
                        <p class="text-xs text-slate-400 truncate">admin@admin.com</p>
                    </div>
                </div>
                <a href="<?= $root_prefix ?>logout.php" title="Sair" class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </a>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-slate-50 relative p-6 md:p-8">
        <div class="max-w-7xl mx-auto w-full space-y-6">
