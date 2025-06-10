<!-- view/painel_admin.view.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Painel Administrativo - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Cabeçalho -->
    <header class="flex justifyext-blue-700">Painel Administrativo</h1>
        <div class="flex gap-4">
            <a href="?rota=logout" -between items-center bg-white shadow-md p-4">
        <h1 class="text-2xl font-bold tclass="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Sair</a>
            <a href="?rota=home" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Ver Cardápio</a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-6">
        <!-- Botão para adicionar novo prato -->
        <a href="?rota=adicionar_prato" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow inline-block mb-6">
            ➕ Adicionar novo prato
        </a>

        <h2 class="text-xl font-semibold mb-4 text-gray-800">Lista de Pratos</h2>

        <?php if (empty($pratos)): ?>
            <p class="text-gray-600">Nenhum prato cadastrado.</p>
        <?php else: ?>
            <div class="grid md:grid-cols-2 gap-6">
                <?php foreach ($pratos as $prato): ?>
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="text-lg font-bold"><?= htmlspecialchars($prato['nome']) ?></h3>
                        <p class="text-gray-600"><?= htmlspecialchars($prato['descricao']) ?></p>
                        <p class="text-blue-700 font-semibold">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                        <p class="text-sm text-gray-500">Categoria: <?= htmlspecialchars($prato['categoria']) ?></p>
                        <?php if (!empty($prato['imagem'])): ?>
                            <img src="public/imagens/<?= htmlspecialchars($prato['imagem']) ?>" alt="<?= htmlspecialchars($prato['nome']) ?>" class="w-full h-32 object-cover mt-2 rounded" />
                        <?php endif; ?>
                        <div class="mt-4 flex gap-2">
                            <a href="?rota=editar_prato&id=<?= $prato['id'] ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">Editar</a>
                            <a href="?rota=excluir_prato&id=<?= $prato['id'] ?>" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" onclick="return confirm('Tem certeza que deseja excluir este prato?')">Excluir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
