<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Biblio Senac</title>
</head>

<body class="bg-stone-950 text-stone-200">

    <header class="bg-stone-900 shadow">
        <nav class="max-w-screen-lg mx-auto flex justify-between px-6 py-4">
            <div class="text-xl font-bold text-lime-400">📚 Biblio Senac</div>
            <ul class="flex gap-6 font-semibold">
                <li><a href="/" class="text-lime-400 hover:underline">Explorar</a></li>
                <li><a href="/meus-livros" class="hover:underline">Meus Livros</a></li>
            </ul>
            <ul>
                <li class="hover:underline">Fazer Login</li>
            </ul>
        </nav>
    </header>

    <main class="max-w-screen-lg mx-auto px-6 py-8 space-y-6">
        <?php require "views/{$view}.view.php"; ?>
    </main>

</body>
</html>
