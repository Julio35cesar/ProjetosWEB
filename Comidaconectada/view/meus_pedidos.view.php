<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meus Pedidos - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-white min-h-screen flex flex-col font-sans text-gray-800">

    <!-- Cabeçalho -->
    <header class="bg-green-700 text-white p-6 shadow-md">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="text-4xl font-extrabold tracking-tight drop-shadow-sm">Meus Pedidos</h1>
            <a href="?rota=lista" 
               class="bg-white text-green-700 font-semibold px-5 py-3 rounded-lg shadow hover:bg-green-100 transition duration-300"
               aria-label="Voltar ao Cardápio">
                Voltar ao Cardápio
            </a>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="flex-grow max-w-5xl mx-auto p-6 sm:p-10">
        <?php if (empty($pedidos)): ?>
            <p class="text-center text-gray-600 text-xl mt-20 italic">
                Você ainda não fez nenhum pedido.
            </p>
        <?php else: ?>
            <section class="space-y-10">
                <?php foreach ($pedidos as $pedido): ?>
                    <article class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-green-200 p-6 sm:p-8">
                        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div>
                                <p class="text-gray-700 text-base sm:text-lg font-medium mb-1">
                                    <strong>Data do pedido:</strong> 
                                    <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?>
                                </p>
                                <p>
                                    <strong>Status:</strong> 
                                    <span class="capitalize font-semibold px-3 py-1 rounded-full text-sm
                                        <?php
                                            switch ($pedido['status']) {
                                                case 'finalizado': echo 'bg-green-100 text-green-800'; break;
                                                case 'pendente': echo 'bg-yellow-100 text-yellow-800'; break;
                                                case 'cancelado': echo 'bg-red-100 text-red-800'; break;
                                                case 'em preparo': echo 'bg-blue-100 text-blue-800'; break;
                                                default: echo 'bg-gray-100 text-gray-600';
                                            }
                                        ?>
                                    ">
                                        <?= htmlspecialchars($pedido['status']) ?>
                                    </span>
                                </p>
                            </div>

                            <div class="text-xl sm:text-2xl font-extrabold text-green-800 whitespace-nowrap">
                                Total: R$ <?= number_format($pedido['total'], 2, ',', '.') ?>
                            </div>
                        </header>

                        <h3 class="text-lg sm:text-xl font-semibold mb-4 text-green-700 border-b border-green-200 pb-2">
                            Itens do Pedido
                        </h3>
                        <ul class="space-y-3 text-gray-700">
                            <?php foreach ($pedido['itens'] as $item): ?>
                                <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 bg-green-50 rounded-xl p-3 border border-green-100">
                                    <div class="font-medium">
                                        <?= htmlspecialchars($item['nome']) ?> 
                                        <span class="text-sm text-gray-500">× <?= $item['quantidade'] ?></span>
                                    </div>
                                    <div class="text-green-800 font-semibold">
                                        R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?>
                                    </div>
                                    <?php if (!empty($item['observacao'])): ?>
                                        <div class="text-sm italic text-gray-500 sm:max-w-xl">
                                            Obs: <?= htmlspecialchars($item['observacao']) ?>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>

    <!-- Rodapé -->
    <footer class="bg-green-700 text-white text-center p-5 mt-12 font-light select-none">
        &copy; <?= date('Y') ?> Comida Conectada - Todos os direitos reservados
    </footer>

</body>
</html>
