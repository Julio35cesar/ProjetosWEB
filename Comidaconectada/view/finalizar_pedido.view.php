<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Finalizar Pedido - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <header class="max-w-3xl mx-auto flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">Finalizar Pedido</h1>
        <a href="?rota=carrinho" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded transition">Voltar ao Carrinho</a>
    </header>

    <?php if (empty($itens) || $total <= 0): ?>
        <p class="text-center text-gray-600">Seu carrinho está vazio.</p>
    <?php else: ?>
        <section class="bg-white p-6 rounded shadow max-w-3xl mx-auto">
            <h2 class="text-xl font-semibold mb-4">Resumo do Pedido</h2>
            <ul class="mb-4 list-disc list-inside">
                <?php foreach ($itens as $item): ?>
                    <li><?= htmlspecialchars($item['nome']) ?> - Quantidade: <?= $item['quantidade'] ?> - R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></li>
                <?php endforeach; ?>
            </ul>
            <p class="mb-6 font-semibold">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>

            <form action="?rota=finalizar_pedido" method="post" class="space-y-4">
                <label class="block">
                    <span class="font-semibold">Nome Completo:</span>
                    <input type="text" name="nome_cliente" required class="w-full border rounded px-3 py-2" />
                </label>
                <label class="block">
                    <span class="font-semibold">Telefone:</span>
                    <input type="tel" name="telefone" required class="w-full border rounded px-3 py-2" />
                </label>
                <label class="block">
                    <span class="font-semibold">Endereço de Entrega:</span>
                    <textarea name="endereco" required class="w-full border rounded px-3 py-2"></textarea>
                </label>
                <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 transition">Confirmar Pedido</button>
            </form>
        </section>
    <?php endif; ?>

</body>
</html>
