<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Adicionar Prato - Administração</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Adicionar Novo Prato</h1>

        <?php if (!empty($msg)): ?>
            <div class="mb-6 px-4 py-3 rounded <?= isset($erro) && $erro ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800' ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form  method="POST" enctype="multipart/form-data" class="space-y-5">
            
            <div>
                <label for="nome" class="block font-semibold text-gray-700 mb-1">Nome do Prato:</label>
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>"
                />
            </div>

            <div>
                <label for="descricao" class="block font-semibold text-gray-700 mb-1">Descrição:</label>
                <textarea
                    id="descricao"
                    name="descricao"
                    rows="3"
                    required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                ><?= isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : '' ?></textarea>
            </div>

            <div>
                <label for="preco" class="block font-semibold text-gray-700 mb-1">Preço (R$):</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    id="preco"
                    name="preco"
                    required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="<?= isset($_POST['preco']) ? htmlspecialchars($_POST['preco']) : '' ?>"
                />
            </div>

            <div>
                <label for="categoria" class="block font-semibold text-gray-700 mb-1">Categoria:</label>
                <select
                    id="categoria"
                    name="categoria"
                    required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                >
                    <option value="">Selecione</option>
                    <?php
                    $categorias = ['Entrada', 'Prato', 'Sobremesa', 'Bebida', 'Vegano'];
                    $selectedCat = $_POST['categoria'] ?? '';
                    foreach ($categorias as $cat):
                    ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $selectedCat === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="imagem" class="block font-semibold text-gray-700 mb-1">Imagem do Prato:</label>
                <input  
                    type="file"
                    id="imagem"
                    name="imagem"
                    accept="image/*"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                />
            </div>

            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded transition"
                >
                    Salvar Prato
                </button>

                <a href="?rota=admin" class="text-blue-600 hover:underline">← Voltar ao Painel</a>
            </div>
        </form>
    </div>

</body>
</html>
