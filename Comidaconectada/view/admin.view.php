<?php
// Pega a aba atual da URL ou define 'pratos' como padrão
$aba = $_GET['aba'] ?? 'pratos';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Administração - Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<header class="max-w-5xl mx-auto flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-blue-700">Painel de Administração</h1>
    <nav class="space-x-4">
        <!-- Link para voltar ao cardápio público -->
        <a href="?rota=lista" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded">Ver Cardápio</a>
        <!-- Link para logout -->
        <a href="?rota=logout" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded">Logout</a>
    </nav>
</header>

<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow-md">

    <!-- Menu das abas -->
    <nav class="mb-6 flex space-x-4 border-b border-gray-300">
        <?php 
            $abas = ['pratos' => 'Pratos', 'pedidos' => 'Pedidos', 'usuarios' => 'Usuários'];
            foreach ($abas as $key => $nome): 
                $ativo = ($aba === $key);
        ?>
            <a href="?rota=admin&aba=<?= $key ?>" 
               class="<?= $ativo ? 'border-b-4 border-blue-600 font-semibold text-blue-700' : 'text-gray-600 hover:text-blue-600' ?> px-3 py-2">
               <?= $nome ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Conteúdo da aba -->
    <section>
        <?php if ($aba === 'pratos'): ?>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Pratos Cadastrados</h2>
                <!-- Botão para abrir formulário de adicionar prato -->
                <a href="?rota=adicionar" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">+ Novo Prato</a>
            </div>

            <?php if (empty($pratos)): ?>
                <p class="text-gray-600">Nenhum prato cadastrado ainda.</p>
            <?php else: ?>
                <table class="w-full table-auto border-collapse border border-gray-300 text-center">
                    <thead>
                        <tr class="bg-blue-100">
                            <th class="border border-gray-300 px-4 py-2">Imagem</th>
                            <th class="border border-gray-300 px-4 py-2">Nome</th>
                            <th class="border border-gray-300 px-4 py-2">Descrição</th>
                            <th class="border border-gray-300 px-4 py-2">Categoria</th>
                            <th class="border border-gray-300 px-4 py-2">Preço (R$)</th>
                            <th class="border border-gray-300 px-4 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pratos as $p): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 p-2">
                                    <?php if (!empty($p['imagem'])): ?>
                                        <img src="public/imagens/<?= htmlspecialchars($p['imagem']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>" class="w-20 h-20 object-cover mx-auto rounded" />
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Sem imagem</span>
                                    <?php endif; ?>
                                </td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($p['nome']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($p['descricao']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($p['categoria'] ?? 'Sem categoria') ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= number_format($p['preco'], 2, ',', '.') ?></td>
                                <td class="border border-gray-300 px-4 py-2 space-x-2">
                                    <a href="?rota=formEditar&id=<?= $p['id'] ?>" class="bg-yellow-400 px-3 py-1 rounded hover:bg-yellow-500">Editar</a>
                                    <a href="?rota=excluir&id=<?= $p['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este prato?');" class="bg-red-600 px-3 py-1 rounded text-white hover:bg-red-700">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php elseif ($aba === 'pedidos'): ?>
            <h2 class="text-xl font-semibold mb-4">Pedidos</h2>

            <?php if (empty($pedidos)): ?>
                <p class="text-gray-600">Nenhum pedido realizado.</p>
            <?php else: ?>
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-green-100">
                            <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Cliente</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Itens</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Resposta</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 text-center"><?= $pedido['id'] ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($pedido['cliente_nome']) ?></td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <ul class="list-disc list-inside">
                                        <?php foreach ($pedido['itens'] as $item): ?>
                                            <li><?= htmlspecialchars($item['nome']) ?> x <?= $item['quantidade'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($pedido['status']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($pedido['resposta'] ?? '') ?></td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="?rota=responder_pedido&id=<?= $pedido['id'] ?>" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Responder</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php elseif ($aba === 'usuarios'): ?>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Usuários Cadastrados</h2>
                <a href="?rota=login" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">+ Novo Usuário</a>
            </div>

            <?php if (empty($usuarios)): ?>
                <p class="text-gray-600">Nenhum usuário cadastrado.</p>
            <?php else: ?>
                <table class="w-full table-auto border-collapse border border-gray-300 text-center">
                    <thead>
                        <tr class="bg-yellow-100">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nome</th>
                            <th class="border border-gray-300 px-4 py-2">E-mail</th>
                            <th class="border border-gray-300 px-4 py-2">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2"><?= $user['id'] ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($user['nome']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($user['tipo']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-red-600 font-semibold">Aba inválida.</p>
        <?php endif; ?>
    </section>

</div>

</body>
</html>
