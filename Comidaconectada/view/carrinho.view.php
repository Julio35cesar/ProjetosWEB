<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/Prato.php';

$carrinho = $_SESSION['carrinho'] ?? [];
// $carrinho espera formato:
// [
//   id_prato => ['quantidade' => int, 'observacao' => string]
// ]

// Se for um array simples (id => quantidade), adapte conforme necessário.

$ids = array_keys($carrinho);
$pratos = Prato::buscarPorIds($ids);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Carrinho - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-50 min-h-screen">

    <!-- Cabeçalho -->
    <header class="flex justify-between items-center bg-white shadow-md p-4">
        <h1 class="text-2xl font-bold text-blue-700">🛒 Seu Carrinho</h1>
        <a href="?rota=lista" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Voltar ao Cardápio</a>
    </header>

    <!-- Conteúdo -->
    <main class="max-w-5xl mx-auto p-6">
        <?php if (empty($carrinho)): ?>
            <p class="text-center text-gray-600 text-lg mt-10">Seu carrinho está vazio.</p>
        <?php else: ?>
            <form action="atualizarCarrinho" method="POST" class="bg-white shadow-md rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="p-3 border-b">Prato</th>
                            <th class="p-3 border-b">Quantidade</th>
                            <th class="p-3 border-b">Observação</th>
                            <th class="p-3 border-b text-right">Preço Unit.</th>
                            <th class="p-3 border-b text-right">Subtotal</th>
                            <th class="p-3 border-b text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($pratos as $prato): 
                            $id = $prato['id'];
                            $item = $carrinho[$id];
                            $quantidade = $item['quantidade'] ?? 1;
                            $observacao = $item['observacao'] ?? '';
                            $subtotal = $prato['preco'] * $quantidade;
                            $total += $subtotal;
                        ?>
                        <tr class="border-b hover:bg-yellow-100">
                            <td class="p-3 align-top font-semibold text-gray-800"><?= htmlspecialchars($prato['nome']) ?></td>

                            <td class="p-3 align-top">
                                <input 
                                    type="number" 
                                    name="quantidade[<?= $id ?>]" 
                                    value="<?= $quantidade ?>" 
                                    min="1" 
                                    class="w-16 border rounded px-2 py-1 text-center"
                                />
                            </td>

                            <td class="p-3 align-top">
                                <input 
                                    type="text" 
                                    name="observacao[<?= $id ?>]" 
                                    value="<?= htmlspecialchars($observacao) ?>" 
                                    placeholder="Ex: sem cebola" 
                                    class="w-full border rounded px-2 py-1"
                                />
                            </td>

                            <td class="p-3 align-top text-right">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></td>

                            <td class="p-3 align-top text-right font-semibold">R$ <?= number_format($subtotal, 2, ',', '.') ?></td>

                            <td class="p-3 align-top text-center">
                                <a 
                                  href="?rota=removerCarrinho&id=<?= $id ?>" 
                                  class="text-red-600 hover:underline"
                                  onclick="return confirm('Remover este item do carrinho?');"
                                >Remover</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 font-bold text-gray-700">
                            <td colspan="4" class="p-3 text-right">Total:</td>
                            <td colspan="2" class="p-3 text-right">R$ <?= number_format($total, 2, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-6 flex justify-between flex-wrap gap-3">
                    <a href="?rota=lista" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">Continuar Comprando</a>
                    <div class="flex gap-3">
                        <button 
                          type="submit" 
                          class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2 rounded"
                          title="Atualizar quantidades e observações"
                        >
                          Atualizar Carrinho
                        </button>
                        <a href="?rota=finalizarPedido" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">Finalizar Pedido</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </main>

</body>
</html>
