<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Administração - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">Painel de Administração - Pratos</h1>

    <!-- Formulário para adicionar prato -->
    <section class="max-w-3xl mx-auto bg-white p-6 rounded shadow-md mb-10">
        <h2 class="text-xl font-semibold mb-4">Adicionar Novo Prato</h2>
        <form action="?rota=salvar" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="nome" placeholder="Nome do prato" required class="w-full border rounded px-3 py-2" />
            <textarea name="descricao" placeholder="Descrição" required class="w-full border rounded px-3 py-2"></textarea>
            <input type="number" name="preco" placeholder="Preço" step="0.01" required class="w-full border rounded px-3 py-2" />
            <input type="file" name="imagem" accept="image/*" class="w-full" />
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Adicionar</button>
        </form>
    </section>

    <!-- Lista de pratos -->
    <section class="max-w-5xl mx-auto bg-white p-6 rounded shadow-md">
        <h2 class="text-xl font-semibold mb-4">Pratos Cadastrados</h2>

        <?php if (count($pratos) === 0): ?>
            <p class="text-gray-600">Nenhum prato cadastrado ainda.</p>
        <?php else: ?>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">Imagem</th>
                        <th class="border border-gray-300 px-4 py-2">Nome</th>
                        <th class="border border-gray-300 px-4 py-2">Descrição</th>
                        <th class="border border-gray-300 px-4 py-2">Preço (R$)</th>
                        <th class="border border-gray-300 px-4 py-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pratos as $p): ?>
                    <tr class="text-center hover:bg-gray-50">
                        <td class="border border-gray-300 p-2">
                            <?php if ($p['imagem']): ?>
                                <img src="public/imagens/<?= htmlspecialchars($p['imagem']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>" class="w-20 h-20 object-cover mx-auto rounded" />
                            <?php else: ?>
                                <span class="text-gray-400 italic">Sem imagem</span>
                            <?php endif; ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($p['nome']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($p['descricao']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= number_format($p['preco'], 2, ',', '.') ?></td>
                        <td class="border border-gray-300 px-4 py-2 space-x-2">
                            <a href="?rota=formEditar&id=<?= $p['id'] ?>" class="bg-yellow-400 px-3 py-1 rounded hover:bg-yellow-500 transition">Editar</a>
                            <a href="?rota=excluir&id=<?= $p['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este prato?');" class="bg-red-600 px-3 py-1 rounded text-white hover:bg-red-700 transition">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

</body>
</html>

