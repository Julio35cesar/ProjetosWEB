<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-green-100 to-white min-h-screen font-sans">

    <!-- Cabeçalho -->
    <header class="bg-green-600 text-white p-4 shadow-md">
        <h1 class="text-3xl font-bold text-center">🍽️ Comida Conectada</h1>
    </header>

    <!-- Lista de pratos -->
    <main class="p-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($pratos as $prato): ?>
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                    <img src="public/imagens/<?= $prato['imagem'] ?>" alt="<?= $prato['nome'] ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-green-700"><?= $prato['nome'] ?></h2>
                        <p class="text-gray-600 text-sm"><?= $prato['descricao'] ?></p>
                        <p class="text-yellow-600 font-bold text-lg mt-1">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                        <button onclick="adicionarCarrinho('<?= $prato['nome'] ?>')" class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl w-full">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Botão flutuante do WhatsApp -->
    <a href="https://wa.me/seunumero" target="_blank" class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" class="w-6 h-6" alt="WhatsApp">
    </a>

    <script>
    function adicionarCarrinho(nome) {
        alert(nome + " adicionado ao carrinho!");
    }
    </script>
</body>
</html>
