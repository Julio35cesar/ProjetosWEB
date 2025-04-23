<?php
require 'dados.php';
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-stone-950 text-stone-200">

    <header class="bg-stone-900">
        <nav class="mx-auto max-w-screen-lg flex justify-between px-8 py-4">
            <div class="font-bold text-xl tracking-wide">Biblio Senac </div>
            <ul class="flex space-x-4 font-bold">
                <li><a href="/" class="text-lime-500">Explorar</a></li>
                <li><a href="meus-livros" class="hover:underline">Meus Livros</a></li>
            </ul>

            <ul>
                <li class="hover:underline">Fazer Login</li>
            </ul>
        </nav>
    </header>

    <main class="mx-auto max-w-screen-lg space-y-6">
        <form action="livro.php" class="w-full flex space-x-2 mt-6">
            <input type="text"
                class="border-stone-800 border-2 rounded-md bg-stone-900 text-sm focus:outline-none px-2 py-1"
                placeholder="Pesquisar..." />
            <button type="submit">Pesquisar</button>
        </form>
        <section class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-5">
            <?php foreach ($livros as $livro): ?>
                <div class="p-2 roudend border-stone-800 border-2 bg-stone-900 m-1">
                    <div class="flex">
                        <div class="w-1/3">Imagem</div>
                        <div>
                            <a href="/livro.php?id=<?= $livro['id']; ?>" class="font-semibold hover:underline"><?= $livro['titulo']; ?></a>
                            <div class="text-xs italic"><?= $livro['autor']; ?></div>
                            <div>⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                    <div>
                    <?= $livro['descricao']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>


</body>

</html>
