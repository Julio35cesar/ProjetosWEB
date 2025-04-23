<h1 class="text-2xl font-bold mb-4">Lista de Produtos</h1>

<section class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-5">
    <?php foreach ($produtos as $produto): ?>
        <div class="p-4 bg-stone-900 border border-stone-800 rounded">
            <div class="font-semibold text-lg"><?= $produto['nome'] ?></div>
            <div class="text-sm italic"><?= $produto['categoria'] ?></div>
            <p class="mt-2"><?= $produto['descricao'] ?></p>
            <div class="mt-2 text-lime-400 font-bold">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>
        </div>
    <?php endforeach; ?>
</section>
