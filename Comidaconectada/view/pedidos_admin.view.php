<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Pedidos dos Clientes - Administração - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-blue-700 text-white p-4 shadow">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl">Painel Administrativo - Comida Conectada</h1>
            <nav class="space-x-4">
                <a href="?rota=admin" class="hover:underline">Dashboard</a>
                <a href="?rota=pedidos_admin" class="hover:underline font-semibold">Pedidos</a>
                <a href="?rota=logout" class="hover:underline">Logout</a>
            </nav>
        </div>
    </header>

    <main class="flex-grow max-w-6xl mx-auto bg-white p-6 mt-8 rounded shadow">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">Pedidos Finalizados</h2>

        <?php if (count($pedidos) === 0): ?>
            <p class="text-gray-600">Nenhum pedido finalizado até agora.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="bg-white rounded shadow p-4 mb-6 border border-gray-300">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        Pedido #<?= $pedido['id'] ?> - <?= htmlspecialchars($pedido['cliente']) ?> - <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?>
                    </h3>
                    <p>Status: <strong class="capitalize"><?= htmlspecialchars($pedido['status']) ?></strong></p>
                    <p>Total: <strong>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></strong></p>

                    <ul class="mt-2 list-disc pl-6 text-gray-700">
                        <?php foreach ($pedido['itens'] as $item): ?>
                            <li>
                                <?= $item['quantidade'] ?>x <?= htmlspecialchars($item['nome']) ?> - R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?>
                                <?php if (!empty($item['observacao'])): ?>
                                    <span class="italic text-gray-500">(Obs: <?= htmlspecialchars($item['observacao']) ?>)</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <form method="POST" action="?rota=responder" class="mt-4 space-y-2">
                        <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>" />

                        <label class="block text-sm font-medium text-gray-700">Status:</label>
                        <select name="status" class="border rounded px-3 py-1 w-full">
                            <option value="pendente" <?= $pedido['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                            <option value="em preparo" <?= $pedido['status'] === 'em preparo' ? 'selected' : '' ?>>Em preparo</option>
                            <option value="pronto" <?= $pedido['status'] === 'pronto' ? 'selected' : '' ?>>Pronto</option>
                            <option value="entregue" <?= $pedido['status'] === 'entregue' ? 'selected' : '' ?>>Entregue</option>
                            <option value="cancelado" <?= $pedido['status'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                        </select>

                        <label class="block text-sm font-medium text-gray-700 mt-2">Resposta para o cliente:</label>
                        <textarea name="resposta_admin" class="w-full border rounded px-3 py-1" placeholder="Digite uma resposta..."><?= htmlspecialchars($pedido['resposta_admin'] ?? '') ?></textarea>

                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded transition">
                            Atualizar
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <footer class="bg-gray-200 text-center p-4 mt-8 text-gray-600 text-sm">
        &copy; <?= date('Y') ?> Comida Conectada - Todos os direitos reservados.
    </footer>
</body>
</html>
