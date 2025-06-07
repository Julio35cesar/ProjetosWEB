<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meus Pedidos - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Cabeçalho com navegação -->
    <header class="bg-blue-700 text-white p-4 shadow">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl">Comida Conectada</h1>
            <nav class="space-x-4">
                <a href="?rota=lista" class="hover:underline">Cardápio</a>
                <a href="?rota=meus_pedidos" class="hover:underline font-semibold">Meus Pedidos</a>
                <a href="?rota=logout" class="hover:underline">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="flex-grow max-w-6xl mx-auto bg-white p-6 mt-8 rounded shadow">
        <h2 class="text-2xl font-bold text-blue-700 mb-6">Meus Pedidos</h2>

        <?php if (empty($pedidos)): ?>
            <p class="text-gray-600">Você ainda não realizou nenhum pedido.</p>
        <?php else: ?>
            <!-- Loop pelos pedidos -->
            <?php foreach ($pedidos as $pedido): ?>
                <div class="mb-8 border border-gray-300 rounded p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <span class="font-semibold text-gray-700">Pedido #<?= $pedido['id'] ?></span>
                            <span class="text-gray-500 ml-2"><?= date('d/m/Y H:i', strtotime($pedido['data'])) ?></span>
                        </div>
                        <div>
                            <!-- Badge de status com cor dinâmica -->
                            <span class="px-3 py-1 rounded 
                                <?php 
                                switch ($pedido['status']) {
                                    case 'finalizado': echo 'bg-green-200 text-green-800'; break;
                                    case 'pendente': echo 'bg-yellow-200 text-yellow-800'; break;
                                    case 'cancelado': echo 'bg-red-200 text-red-800'; break;
                                    case 'em preparo': echo 'bg-blue-200 text-blue-800'; break;
                                    case 'pronto': echo 'bg-purple-200 text-purple-800'; break;
                                    case 'entregue': echo 'bg-indigo-200 text-indigo-800'; break;
                                    default: echo 'bg-gray-200 text-gray-700';
                                }
                                ?>
                            ">
                                <?= ucfirst($pedido['status']) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Tabela de itens do pedido -->
                    <table class="w-full text-left border-collapse border border-gray-300">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="border border-gray-300 px-3 py-2">Prato</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Quantidade</th>
                                <th class="border border-gray-300 px-3 py-2">Observação</th>
                                <th class="border border-gray-300 px-3 py-2 text-right">Preço Unitário</th>
                                <th class="border border-gray-300 px-3 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedido['itens'] as $item): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($item['nome']) ?></td>
                                    <td class="border border-gray-300 px-3 py-2 text-center"><?= $item['quantidade'] ?></td>
                                    <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($item['observacao']) ?></td>
                                    <td class="border border-gray-300 px-3 py-2 text-right">R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                                    <td class="border border-gray-300 px-3 py-2 text-right">R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Total do pedido -->
                    <div class="mt-3 text-right font-semibold text-lg text-gray-800">
                        Total do pedido: R$ <?= number_format($pedido['total'], 2, ',', '.') ?>
                    </div>

                    <!-- Se tiver resposta do admin -->
                    <?php if (!empty($pedido['resposta_admin'])): ?>
                        <div class="mt-2 p-3 bg-gray-100 border-l-4 border-blue-500 text-blue-700">
                            <strong>Resposta do Restaurante:</strong> <?= htmlspecialchars($pedido['resposta_admin']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="?rota=lista" class="text-blue-600 hover:underline font-semibold">Voltar ao Cardápio</a>
        </div>
    </main>

    <!-- Rodapé -->
    <footer class="bg-gray-200 text-center p-4 mt-8 text-gray-600 text-sm">
        &copy; <?= date('Y') ?> Comida Conectada - Todos os direitos reservados.
    </footer>
</body>
</html>
