<!-- views/cardapio.view.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comida Conectada</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

  <!-- Header -->
  <header class="bg-red-600 text-white flex items-center justify-between p-4 fixed w-full top-0 z-50 shadow-md">
    <div class="flex items-center gap-2">
      <button class="text-white text-2xl">&#9776;</button>
      <span class="font-bold text-lg">Comida Conectada</span>
    </div>
    <button>
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M21 21l-6-6m0 0a7 7 0 1 0-10 0 7 7 0 0 0 10 0z"/>
      </svg>
    </button>
  </header>

  <div class="h-20"></div> <!-- Espaço pro header -->

  <!-- Banner -->
  <div class="w-full">
    <img src="imagens/banner.jpg" alt="Banner do restaurante" class="w-full h-52 object-cover">
  </div>

  <!-- Status -->
  <div class="text-center my-3">
    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">🟢 Aberto - Fecha às 23:00</span>
    <p class="text-sm text-gray-600 mt-1">Entrega: 45min - 60min | Retirada: 20min</p>
  </div>

  <!-- Categorias (Estáticos por enquanto) -->
  <div class="flex flex-wrap justify-center gap-2 p-4">
    <button class="border px-3 py-1 rounded hover:bg-gray-100">Destaques</button>
    <button class="border px-3 py-1 rounded hover:bg-gray-100">Combinados</button>
    <button class="border px-3 py-1 rounded hover:bg-gray-100">Bebidas</button>
    <button class="border px-3 py-1 rounded hover:bg-gray-100">Sobremesas</button>
  </div>

  <!-- Lista de pratos -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-4 pb-16">
    <?php foreach ($pratos as $prato): ?>
      <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
        <img src="imagens/<?= $prato->imagem ?>" alt="<?= $prato->nome ?>" class="w-full h-48 object-cover">
        <div class="p-3">
          <h2 class="text-lg font-semibold"><?= $prato->nome ?></h2>
          <p class="text-sm text-gray-600"><?= $prato->descricao ?></p>
          <span class="text-green-600 font-bold block mt-2">R$ <?= number_format($prato->preco, 2, ',', '.') ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- WhatsApp -->
  <a href="https://wa.me/seunumerowhatsapp" target="_blank" class="fixed bottom-4 right-4 bg-green-500 p-3 rounded-full shadow-lg hover:bg-green-600">
    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
      <path d="M20.52 3.48A10 10 0 1 0 3.48 20.52l2.54-7.37a6.5 6.5 0 0 1 9.37-9.37l7.37-2.54z"/>
    </svg>
  </a>

</body>
</html>
