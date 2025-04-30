<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comida Conectada</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-2xl p-10 text-center max-w-md w-full">
        <!-- Título -->
        <h1 class="text-3xl font-bold text-orange-600 mb-4">🍽️ Bem-vindo ao Comida Conectada</h1>
        
        <!-- Frase de destaque -->
        <p class="text-gray-700 text-lg mb-6">
            Descubra os sabores autênticos da culinária brasileira!
        </p>

        <!-- Botões de navegação -->
        <div class="flex flex-col gap-4">
            <a href="?rota=cardapio" class="bg-orange-500 hover:bg-orange-600 text-white py-3 px-6 rounded-lg font-semibold transition">
                Ver Cardápio
            </a>
            <a href="?rota=pedido" class="bg-orange-500 hover:bg-orange-600 text-white py-3 px-6 rounded-lg font-semibold transition">
                Fazer Pedido
            </a>
            <a href="?rota=admin/login" class="bg-gray-700 hover:bg-gray-800 text-white py-3 px-6 rounded-lg font-semibold transition">
                Área Administrativa
            </a>
        </div>
    </div>

</body>
</html>
