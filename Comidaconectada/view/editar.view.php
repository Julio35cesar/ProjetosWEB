<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Editar Prato - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">Editar Prato</h1>

    <section class="max-w-3xl mx-auto bg-white p-6 rounded shadow-md">
        <form action="?rota=editar" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($prato['id']) ?>" />

            <label class="block">
                <span class="font-semibold">Nome do prato</span>
                <input type="text" name="nome" required value="<?= htmlspecialchars($prato['nome']) ?>" class="w-full border rounded px-3 py-2" />
            </label>

            <label class="block">
                <span class="font-semibold">Descrição</span>
                <textarea name="descricao" required class="w-full border rounded px-3 py-2"><?= htmlspecialchars($prato['descricao']) ?></textarea>
            </label>

            <label class="block">
                <span class="font-semibold">Preço (R$)</span>
                <input type="number" step="0.01" name="preco" required value="<?= htmlspecialchars($prato['preco']) ?>" class="w-full border rounded px-3 py-2" />
            </label>

            <label class="block">
                <span class="font-semibold">Imagem atual</span><br/>
                <?php if ($prato['imagem']): ?>
                    <img src="public/imagens/<?= htmlspecialchars($prato['imagem']) ?>" alt="Imagem do prato" class="w-32 h-32 object-cover rounded mb-3" />
                <?php else: ?>
                    <span class="text-gray-400 italic">Sem imagem</span>
                <?php endif; ?>
            </label>

            <label class="block">
                <span class="font-semibold">Nova imagem (opcional)</span>
                <input type="file" name="imagem" accept="image/*" class="w-full" />
            </label>

            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Salvar Alterações</button>
            <a href="?rota=admin" class="inline-block ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </section>

</body>
</html>
