<?php
require_once 'config/config.php';
require_once 'models/DB.php';
require_once 'controllers/PratoController.php';

$database = new DB($config);
$pratoController = new PratoController($database);
$pratos = $pratoController->getPratos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comida Conectada - Cardápio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brasil: '#009739',
                        tecnologia: '#0F172A',
                        destaque: '#FFD700',
                        quente: '#FF5733',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white text-gray-900">

    <!-- NAVBAR -->
    <nav class="bg-brasil p-4 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl font-extrabold tracking-wide">Comida Conectada</div>
            <div class="space-x-4">
                <a href="#" class="hover:text-destaque">Login</a>
                <a href="#" class="hover:text-destaque">Carrinho</a>
                <a href="#" class="hover:text-destaque">Contato</a>
            </div>
        </div>
    </nav>

    <!-- BANNER -->
    <section class="text-white text-center py-12 bg-gradient-to-r from-quente to-destaque">
        <h1 class="text-5xl font-bold mb-2">Sabores do Brasil com um Toque de Tecnologia</h1>
        <p class="text-xl">Peça online, receba com agilidade e saboreie qualidade.</p>
    </section>

    <!-- CATEGORIAS -->
    <div class="container mx-auto mt-6 px-4 flex flex-wrap justify-center gap-2">
        <?php
        $categorias = ['Todos', 'Pratos', 'Bebidas', 'Sobremesas', 'Vegano', 'Promoções'];
        foreach ($categorias as $cat) {
            echo "<button class='bg-destaque text-black font-semibold px-4 py-2 rounded-full hover:bg-quente transition'>$cat</button>";
        }
        ?>
    </div>

    <!-- CAMPO DE BUSCA -->
    <div class="container mx-auto px-4 mt-6">
        <input type="text" placeholder="Buscar prato..." class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-destaque" />
    </div>

    <!-- CARDÁPIO -->
    <div class="container mx-auto my-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
        <?php foreach ($pratos as $prato): ?>
            <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-xl transform hover:scale-105 transition">
                <img src="<?php echo $prato['imagem']; ?>" alt="Imagem do prato" class="w-full h-52 object-cover rounded-t-lg">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-brasil"><?php echo $prato['nome']; ?></h2>
                    <p class="text-sm text-gray-600 mt-1"><?php echo $prato['descricao']; ?></p>
                    <p class="text-lg font-semibold text-quente mt-2">R$ <?php echo number_format($prato['preco'], 2, ',', '.'); ?></p>
                    <button class="mt-3 w-full bg-destaque text-black py-2 rounded-full hover:bg-brasil hover:text-white transition">Adicionar ao Carrinho</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- WHATSAPP BUTTON -->
    <a href="https://wa.me/SEUNUMEROAQUI" target="_blank" class="fixed bottom-5 right-5 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition z-50">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.52 3.48A11.94 11.94 0 0012.04 0C5.37 0 0 5.37 0 12.04c0 2.12.55 4.15 1.61 5.96L0 24l6.23-1.63a11.98 11.98 0 0017.3-10.33c0-3.19-1.24-6.19-3.51-8.56zM12.04 22.11c-1.91 0-3.79-.52-5.42-1.51l-.39-.23-3.68.96.98-3.58-.25-.37A9.9 9.9 0 012.1 12.04c0-5.49 4.45-9.94 9.94-9.94s9.94 4.45 9.94 9.94-4.45 9.94-9.94 9.94zm5.4-7.46l-2.23-.63a.92.92 0 00-.88.24l-.69.71a9.78 9.78 0 01-4.58-4.58l.71-.69a.92.92 0 00.24-.88l-.63-2.23a.92.92 0 00-.88-.67H8.13a1.85 1.85 0 00-1.85 1.85c0 6.1 4.95 11.05 11.05 11.05a1.85 1.85 0 001.85-1.85v-1.33a.92.92 0 00-.67-.88z"/>
        </svg>
    </a>

    <!-- RODAPÉ -->
    <footer class="bg-tecnologia text-white py-6 mt-10">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Comida Conectada | Todos os direitos reservados</p>
        </div>
    </footer>

</body>
</html>
