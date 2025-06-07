<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários Cadastrados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">Usuários Cadastrados</h2>

        <?php if (count($usuarios) === 0): ?>
            <p class="text-gray-600">Nenhum usuário cadastrado.</p>
        <?php else: ?>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nome</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr class="text-center hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2"><?= $u['id'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($u['nome']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($u['email']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $u['tipo'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
