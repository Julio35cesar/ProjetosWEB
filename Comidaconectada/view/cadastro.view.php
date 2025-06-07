<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastro - Comida Conectada</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center min-h-screen px-4">

  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md border border-green-300">
    <h2 class="text-3xl font-extrabold mb-6 text-center text-green-800 tracking-wide">
      Crie sua conta
    </h2>

    <!-- Exibe mensagem de erro se existir -->
    <?php if (isset($erro)): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-6 rounded border border-red-300 shadow-sm text-sm text-center">
        <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <!-- Formulário de cadastro -->
    <form method="post" action="?rota=cadastro" class="space-y-5" novalidate>
      <div>
        <label for="nome" class="block text-gray-800 font-semibold mb-1">Nome Completo</label>
        <input
          type="text"
          id="nome"
          name="nome"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition"
          placeholder="Seu nome completo"
          autocomplete="name"
        />
      </div>

      <div>
        <label for="email" class="block text-gray-800 font-semibold mb-1">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition"
          placeholder="exemplo@dominio.com"
          autocomplete="email"
        />
      </div>

      <div>
        <label for="senha" class="block text-gray-800 font-semibold mb-1">Senha</label>
        <input
          type="password"
          id="senha"
          name="senha"
          required
          minlength="6"
          class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition"
          placeholder="Digite uma senha (mínimo 6 caracteres)"
          autocomplete="new-password"
        />
      </div>

      <div>
        <label for="confirma_senha" class="block text-gray-800 font-semibold mb-1">Confirmar Senha</label>
        <input
          type="password"
          id="confirma_senha"
          name="confirma_senha"
          required
          minlength="6"
          class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition"
          placeholder="Repita a senha"
          autocomplete="new-password"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-md shadow-md transition"
      >
        Cadastrar
      </button>
    </form>

    <!-- Link para login -->
    <p class="mt-7 text-center text-gray-700">
      Já tem uma conta?
      <a href="?rota=login" class="text-green-700 font-semibold hover:underline">Faça login aqui</a>
    </p>
  </div>

</body>
</html>
