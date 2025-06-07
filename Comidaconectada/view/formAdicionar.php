<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Adicionar Novo Prato - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <h1 class="text-3xl font-bold mb-6 text-center text-green-700">Adicionar Novo Prato</h1>

    <section class="max-w-3xl mx-auto bg-white p-6 rounded shadow-md">
        <form action="?rota=salvar" method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- Nome do prato -->
            <label for="nome" class="block">
                <span class="font-semibold">Nome do prato</span>
                <input id="nome" type="text" name="nome" required class="w-full border rounded px-3 py-2" />
            </label>

            <!-- Descrição -->
            <label for="descricao" class="block">
                <span class="font-semibold">Descrição</span>
                <textarea id="descricao" name="descricao" required class="w-full border rounded px-3 py-2"></textarea>
            </label>

            <!-- Preço -->
            <label for="preco" class="block">
                <span class="font-semibold">Preço (R$)</span>
                <input id="preco" type="number" step="0.01" name="preco" required class="w-full border rounded px-3 py-2" />
            </label>

            <!-- Categoria -->
            <label for="categoria" class="block">
                <span class="font-semibold">Categoria</span>
                <select id="categoria" name="categoria" required class="w-full border rounded px-3 py-2">
                    <?php
                    $categorias = ['Entrada', 'Prato Principal', 'Sobremesa', 'Bebida'];
                    foreach ($categorias as $cat) {
                        echo "<option value=\"" . htmlspecialchars($cat) . "\">" . htmlspecialchars($cat) . "</option>";
                    }
                    ?>
                </select>
            </label>

            <!-- Imagem -->
            <label for="imagem" class="block">
                <span class="font-semibold">Imagem</span>
                <input id="imagem" type="file" name="imagem" accept="image/*" class="w-full" />
            </label>

            <!-- Botões -->
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 transition">Adicionar Prato</button>
            <a href="?rota=admin" class="inline-block ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </section>

</body>
</html>
