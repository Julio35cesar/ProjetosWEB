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
            <!-- Campo oculto para enviar o ID do prato -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($prato['id']) ?>" />

            <!-- Campo para editar o nome do prato -->
            <label for="nome" class="block">
                <span class="font-semibold">Nome do prato</span>
                <input id="nome" type="text" name="nome" required value="<?= htmlspecialchars($prato['nome']) ?>" class="w-full border rounded px-3 py-2" />
            </label>

            <!-- Campo para editar a descrição do prato -->
            <label for="descricao" class="block">
                <span class="font-semibold">Descrição</span>
                <textarea id="descricao" name="descricao" required class="w-full border rounded px-3 py-2"><?= htmlspecialchars($prato['descricao']) ?></textarea>
            </label>

            <!-- Campo para editar o preço -->
            <label for="preco" class="block">
                <span class="font-semibold">Preço (R$)</span>
                <input id="preco" type="number" step="0.01" name="preco" required value="<?= htmlspecialchars($prato['preco']) ?>" class="w-full border rounded px-3 py-2" />
            </label>

            <!-- Campo para selecionar categoria -->
            <label for="categoria" class="block">
                <span class="font-semibold">Categoria</span>
                <select id="categoria" name="categoria" required class="w-full border rounded px-3 py-2">
                    <?php
                    // Array com opções de categorias possíveis
                    $categorias = ['Entrada', 'Prato Principal', 'Sobremesa', 'Bebida'];
                    // Loop para gerar as opções do select, já selecionando a categoria atual
                    foreach ($categorias as $cat) {
                        $selected = ($prato['categoria'] === $cat) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($cat) . "\" $selected>" . htmlspecialchars($cat) . "</option>";
                    }
                    ?>
                </select>
            </label>

            <!-- Exibe a imagem atual do prato, se houver -->
            <label class="block">
                <span class="font-semibold">Imagem atual</span><br/>
                <?php if ($prato['imagem']): ?>
                    <img src="public/imagens/<?= htmlspecialchars($prato['imagem']) ?>" alt="Imagem do prato" class="w-32 h-32 object-cover rounded mb-3" />
                <?php else: ?>
                    <span class="text-gray-400 italic">Sem imagem</span>
                <?php endif; ?>
            </label>

            <!-- Campo para envio de nova imagem (opcional) -->
            <label for="imagem" class="block">
                <span class="font-semibold">Nova imagem (opcional)</span>
                <input id="imagem" type="file" name="imagem" accept="image/*" class="w-full" />
            </label>

            <!-- Botões para salvar ou cancelar -->
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Salvar Alterações</button>
            <a href="?rota=admin" class="inline-block ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </section>

</body>
</html>
