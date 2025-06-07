<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meus Pedidos - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <header class="bg-green-700 text-white p-4 shadow-md">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Meus Pedidos</h1>
            <a href="?rota=lista" 
               class="bg-white text-green-700 font-semibold px-4 py-2 rounded shadow hover:bg-green-100 transition">
                Voltar ao Cardápio
            </a>
        </div>
    </header>

    <main class="flex-grow max-w-5xl mx-auto p-6">
        <?php if (empty($pedidos)): ?>
            <p class="text-center text-gray-600 text-lg mt-12">
                Você ainda não fez nenhum pedido.
            </p>
        <?php else: ?>
            <section class="space-y-8">
                <?php foreach ($pedidos as $pedido): ?>
                    <article class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                        <header class="flex justify-between flex-wrap gap-4 mb-4">
                            <div>
                                <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></p>
                                <p><strong>Status:</strong> 
                                    <span class="capitalize
                                        <?php
                                            switch ($pedido['status']) {
                                                case 'finalizado': echo 'text-green-600'; break;
                                                case 'pendente': echo 'text-yellow-600'; break;
                                                case 'cancelado': echo 'text-red-600'; break;
                                                case 'em preparo': echo 'text-blue-600'; break;
                                                default: echo 'text-gray-600';
                                            }
                                        ?>
                                    ">
                                        <?= htmlspecialchars($pedido['status']) ?>
                                    </span>
                                </p>
                            </div>
                            <div class="text-lg font-semibold text-gray-800 self-center">
                                Total: R$ <?= number_format($pedido['total'], 2, ',', '.') ?>
                            </div>
                        </header>

                        <h3 class="font-semibold mb-2 text-gray-700">Itens do Pedido:</h3>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <?php foreach ($pedido['itens'] as $item): ?>
                                <li>
                                    <?= htmlspecialchars($item['nome']) ?> - Quantidade: <?= $item['quantidade'] ?> - 
                                    R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?>
                                    <?php if (!empty($item['observacao'])): ?>
                                        <span class="italic text-gray-500"> (Obs: <?= htmlspecialchars($item['observacao']) ?>)</span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>

    <footer class="bg-green-700 text-white text-center p-4 mt-8">
        &copy; <?= date('Y') ?> Comida Conectada - Todos os direitos reservados
    </footer>

</body>
</html>
