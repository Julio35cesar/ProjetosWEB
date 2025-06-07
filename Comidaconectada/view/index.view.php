<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Comida Conectada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-100 to-white min-h-screen">

    <!-- Barra superior -->
    <header class="flex justify-between items-center bg-white shadow-md p-4">
        <h1 class="text-2xl font-bold text-blue-700">🍽️ Comida Conectada</h1>

        <div class="flex items-center gap-4">
            <?php if (isset($_SESSION['nome'])): ?>
                <span class="text-sm text-gray-700">Olá, <strong><?= htmlspecialchars($_SESSION['nome']) ?></strong></span>
                <a href="?rota=logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Sair</a>
                <?php if ($_SESSION['tipo'] === 'admin'): ?>
                    <a href="?rota=admin" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Admin</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="?rota=login" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="max-w-6xl mx-auto p-6">

        <h2 class="text-3xl font-semibold text-center mb-6 text-gray-800">Nosso Cardápio</h2>

        <!-- Barra de pesquisa -->
        <div class="mb-6 text-center">
            <input 
                type="text" 
                id="pesquisa" 
                placeholder="🔍 Buscar prato..." 
                class="w-full md:w-1/2 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-blue-300" 
                onkeyup="pesquisarPratos()"
            />
        </div>

        <!-- Navbar de Categorias -->
        <nav class="flex flex-wrap justify-center gap-4 mb-8">
            <button onclick="filtrarCategoria('todos')" class="categoria-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Todos</button>
            <button onclick="filtrarCategoria('prato')" class="categoria-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Pratos</button>
            <button onclick="filtrarCategoria('bebida')" class="categoria-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Bebidas</button>
            <button onclick="filtrarCategoria('sobremesa')" class="categoria-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Sobremesas</button>
            <button onclick="filtrarCategoria('vegano')" class="categoria-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Vegano</button>
        </nav>

        <!-- Lista de pratos -->
        <?php if (empty($pratos)): ?>
            <p class="text-center text-gray-600">Nenhum prato cadastrado ainda.</p>
        <?php else: ?>
            <div id="produtos" class="grid md:grid-cols-3 gap-6">
                <?php foreach ($pratos as $prato): ?>
                    <?php
                        $categoria = strtolower($prato['categoria'] ?? 'outra');
                        if ($categoria === 'pratos') $categoria = 'prato';
                        if ($categoria === 'sobremesas') $categoria = 'sobremesa';
                    ?>
                    <div class="produto-card <?= $categoria ?> bg-white shadow rounded overflow-hidden">
                        <?php if (!empty($prato['imagem'])): ?>
                            <img src="public/imagens/<?= htmlspecialchars($prato['imagem']) ?>" alt="<?= htmlspecialchars($prato['nome']) ?>" class="w-full h-40 object-cover" />
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="nome-prato text-xl font-bold text-gray-800"><?= htmlspecialchars($prato['nome']) ?></h3>
                            <p class="text-gray-600 truncate"><?= htmlspecialchars($prato['descricao']) ?></p>
                            <p class="text-blue-700 font-semibold mt-2">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>

                            <!-- Botão para abrir modal -->
                            <button 
                                class="mt-3 w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
                                onclick="abrirModal(<?= htmlspecialchars(json_encode($prato), ENT_QUOTES, 'UTF-8') ?>)"
                            >
                                Ver detalhes
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Botão flutuante do carrinho -->
    <a href="?rota=carrinho" class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg">
        🛒 Carrinho
    </a>

    <!-- Modal para detalhes do prato -->
    <div id="modalDetalhes" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
            <button onclick="fecharModal()" class="absolute top-2 right-3 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
            <h3 id="modalNome" class="text-2xl font-bold mb-2"></h3>
            <p id="modalDescricao" class="mb-4 text-gray-700"></p>
            <p id="modalPreco" class="font-semibold mb-4 text-blue-700"></p>

            <label for="quantidade" class="block mb-1 font-medium">Quantidade:</label>
            <input type="number" id="quantidade" min="1" value="1" class="w-20 border rounded px-2 py-1 mb-4" />

            <label for="observacao" class="block mb-1 font-medium">Observação:</label>
            <textarea id="observacao" rows="3" placeholder="Ex: tirar cebola" class="w-full border rounded px-2 py-1 mb-4"></textarea>

            <button 
                id="btnAdicionarCarrinho" 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full"
            >
                Adicionar ao Carrinho
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        let pratoSelecionado = null;

        // Abre a modal preenchendo com os dados do prato
        function abrirModal(prato) {
            pratoSelecionado = prato;

            document.getElementById('modalNome').textContent = prato.nome;
            document.getElementById('modalDescricao').textContent = prato.descricao;
            document.getElementById('modalPreco').textContent = `R$ ${prato.preco.toFixed(2).replace('.', ',')}`;
            document.getElementById('quantidade').value = 1;
            document.getElementById('observacao').value = '';

            document.getElementById('modalDetalhes').classList.remove('hidden');
        }

        // Fecha a modal
        function fecharModal() {
            document.getElementById('modalDetalhes').classList.add('hidden');
        }

        // Função para adicionar ao carrinho via GET (ou você pode usar fetch/ajax)
        document.getElementById('btnAdicionarCarrinho').addEventListener('click', () => {
            const quantidade = parseInt(document.getElementById('quantidade').value);
            const observacao = document.getElementById('observacao').value.trim();

            if (!pratoSelecionado) return alert('Nenhum prato selecionado');
            if (quantidade < 1) return alert('Informe uma quantidade válida');

            // Construir URL para adicionar ao carrinho
            // Passando id, quantidade e observação via query params (melhor passar POST, mas simplificamos)
            const url = `?rota=adicionarCarrinho&id=${pratoSelecionado.id}&quantidade=${quantidade}&observacao=${encodeURIComponent(observacao)}`;

            // Redireciona para a rota que adiciona no carrinho (backend deve tratar)
            window.location.href = url;
        });

        // Função de filtro simples por categoria
        function filtrarCategoria(cat) {
            const cards = document.querySelectorAll('.produto-card');
            cards.forEach(card => {
                if (cat === 'todos' || card.classList.contains(cat)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Função de busca simples (filtra pelo nome)
        function pesquisarPratos() {
            const filtro = document.getElementById('pesquisa').value.toLowerCase();
            const cards = document.querySelectorAll('.produto-card');
            cards.forEach(card => {
                const nome = card.querySelector('.nome-prato').textContent.toLowerCase();
                card.style.display = nome.includes(filtro) ? 'block' : 'none';
            });
        }
    </script>

</body>
</html>
