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
                    <a href="/livro?id=<?= $livro['id']; ?>" class="font-semibold hover:underline"><?= $livro['titulo']; ?></a>
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