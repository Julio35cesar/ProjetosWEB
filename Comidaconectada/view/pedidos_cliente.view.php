<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meus Pedidos - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Personalização extra para scrollbar da tabela */
        tbody::-webkit-scrollbar {
            height: 8px;
        }
        tbody::-webkit-scrollbar-thumb {
            background-color: #3b82f6; /* azul Tailwind */
            border-radius: 10px;
        }
        tbody {
            display: block;
            max-height: 220px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #3b82f6 transparent;
        }
        thead, tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-blue-50 to-white min-h-screen flex flex-col font-sans text-gray-800">

    <!-- Cabeçalho -->
    <header class="bg-blue-800 text-white shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center p-5">
            <h1 class="text-3xl font-extrabold tracking-wide">Comida Conectada</h1>
            <nav class="space-x-6 text-lg">
                <a href="?rota=lista" class="hover:text-yellow-400 transition-colors duration-300">Cardápio</a>
                <a href="?rota=meus_pedidos" class="font-semibold underline decoration-yellow-400 decoration-2 underline-offset-4">Meus Pedidos</a>
                <a href="?rota=logout" class="hover:text-yellow-400 transition-colors duration-300">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="flex-grow max-w-7xl mx-auto p-8">
        <h2 class="text-4xl font-bold mb-10 text-blue-900 drop-shadow-md">Meus Pedidos</h2>

        <?php if (empty($pedidos)): ?>
            <p class="text-center text-lg text-gray-500 italic mt-20">Você ainda não realizou nenhum pedido.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <section class="bg-white rounded-2xl shadow-lg mb-12 p-8 hover:shadow-2xl transition-shadow duration-300 border border-gray-200">
                    <header class="flex justify-between items-center mb-6">
                        <div>
                            <span class="text-xl font-semibold text-gray-700">Pedido #<?= htmlspecialchars($pedido['id']) ?></span><br />
                            <?php 
                            $dataRaw = $pedido['data'] ?? null;
                            if ($dataRaw && strtotime($dataRaw) !== false) {
                                $dataFormatada = date('d/m/Y H:i', strtotime($dataRaw));
                            } else {
                                $dataFormatada = 'Data não disponível';
                            }
                            ?>
                            <time class="text-sm text-gray-400 tracking-wide" datetime="<?= htmlspecialchars($pedido['data'] ?? '') ?>"><?= $dataFormatada ?></time>
                        </div>
                        <div>
                            <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm
                                <?php 
                                switch (strtolower($pedido['status'] ?? '')) {
                                    case 'finalizado': echo 'bg-green-100 text-green-800'; break;
                                    case 'pendente': echo 'bg-yellow-100 text-yellow-800'; break;
                                    case 'cancelado': echo 'bg-red-100 text-red-800'; break;
                                    case 'em preparo': echo 'bg-blue-100 text-blue-800'; break;
                                    case 'pronto': echo 'bg-purple-100 text-purple-800'; break;
                                    case 'entregue': echo 'bg-indigo-100 text-indigo-800'; break;
                                    default: echo 'bg-gray-100 text-gray-600';
                                }
                                ?>
                            ">
                                <?= ucfirst(htmlspecialchars($pedido['status'] ?? 'Desconhecido')) ?>
                            </span>
                        </div>
                    </header>

                    <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm">
                        <table class="min-w-full text-left table-auto border-collapse">
                            <thead class="bg-gradient-to-r from-blue-300 to-blue-400 text-white uppercase text-sm font-semibold select-none">
                                <tr>
                                    <th class="px-6 py-3">Prato</th>
                                    <th class="px-6 py-3 text-center">Quantidade</th>
                                    <th class="px-6 py-3">Observação</th>
                                    <th class="px-6 py-3 text-right">Preço Unitário</th>
                                    <th class="px-6 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <?php foreach ($pedido['itens'] ?? [] as $item): ?>
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?= htmlspecialchars($item['nome'] ?? '') ?></td>
                                        <td class="px-6 py-4 text-center text-gray-700"><?= intval($item['quantidade'] ?? 0) ?></td>
                                        <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($item['observacao'] ?? '') ?></td>
                                        <td class="px-6 py-4 text-right text-gray-800 font-semibold">R$ <?= number_format(floatval($item['preco'] ?? 0), 2, ',', '.') ?></td>
                                        <td class="px-6 py-4 text-right text-blue-700 font-bold">R$ <?= number_format(floatval($item['preco'] ?? 0) * intval($item['quantidade'] ?? 0), 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end items-center space-x-4">
                        <span class="text-gray-600 font-semibold text-lg">Total do pedido:</span>
                        <span class="text-2xl font-extrabold text-blue-800">R$ <?= number_format(floatval($pedido['total'] ?? 0), 2, ',', '.') ?></span>
                    </div>

                    <?php if (!empty($pedido['resposta_admin'])): ?>
                        <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-600 rounded text-blue-800 font-semibold shadow-sm select-text">
                            <strong>Resposta do Restaurante:</strong> <?= htmlspecialchars($pedido['resposta_admin']) ?>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="mt-12 text-center">
            <a href="?rota=lista" class="inline-block bg-blue-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:bg-yellow-400 hover:text-blue-900 transition-colors duration-300">
                Voltar ao Cardápio
            </a>
        </div>
    </main>

    <!-- Rodapé -->
    <footer class="bg-blue-900 text-blue-200 text-center p-5 mt-16 font-light text-sm select-none">
        &copy; <?= date('Y') ?> Comida Conectada - Todos os direitos reservados.
    </footer>

</body>
</html>
