<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Login - Comida Conectada</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($erro)): ?>
        <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>
    <form method="post" action="?rota=login">
        <label>Usuário:</label><br />
        <input type="text" name="usuario" required /><br /><br />
        <label>Senha:</label><br />
        <input type="password" name="senha" required /><br /><br />
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
