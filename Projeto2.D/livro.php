<?php

require 'dados.php';

$id = $_REQUEST['id'];
$filtrado = array_filtre{$livros}


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
        <section class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-5">

            Conteudo!!

        </section>

    </main>

</body>

</html>

