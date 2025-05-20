<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Prato</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <form action="index.php?rota=adicionar" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Adicionar Prato</h2>

        <input name="nome" class="w-full border p-2 rounded mb-3" placeholder="Nome" required>
        <textarea name="descricao" class="w-full border p-2 rounded mb-3" placeholder="Descrição" required></textarea>
        <input name="preco" type="number" step="0.01" class="w-full border p-2 rounded mb-3" placeholder="Preço" required>
        <input name="imagem" type="file" class="w-full mb-4" required>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Salvar</button>
    </form>
</body>
</html>
