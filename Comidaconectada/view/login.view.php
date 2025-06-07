<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Comida Conectada</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-100 to-white flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
    <h2 class="text-3xl font-extrabold mb-6 text-center text-green-700">Comida Conectada</h2>
    <h3 class="text-lg font-medium mb-6 text-center text-gray-700">Acesse sua conta</h3>

    <?php if (isset($erro)): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded border border-red-300 text-sm text-center">
        <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <!-- Formulário de Login -->
    <form method="post" action="?rota=login" class="space-y-4">
      <div>
        <label for="usuario" class="block text-gray-700 font-semibold mb-1">Usuário (e-mail):</label>
        <input
          type="text"
          id="usuario"
          name="usuario"
          required
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
          placeholder="exemplo@email.com"
        />
      </div>

      <div>
        <label for="senha" class="block text-gray-700 font-semibold mb-1">Senha:</label>
        <input
          type="password"
          id="senha"
          name="senha"
          required
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
          placeholder="Digite sua senha"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-green-600 text-white font-bold py-2 rounded hover:bg-green-700 transition duration-200"
      >
        Entrar
      </button>
    </form>

    <!-- Link para cadastro -->
    <p class="mt-6 text-center text-gray-600 text-sm">
      Ainda não tem uma conta?
      <a href="?rota=cadastro" class="text-green-600 font-semibold hover:underline">Cadastre-se aqui</a>
    </p>
  </div>

</body>
</html>
