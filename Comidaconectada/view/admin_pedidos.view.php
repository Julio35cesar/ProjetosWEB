<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Pedidos Pendentes - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .pedido { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
        h3 { margin-top: 0; }
        ul { list-style: none; padding-left: 0; }
        li { margin-bottom: 5px; }
        label { display: block; margin-top: 10px; }
        textarea { width: 100%; height: 60px; }
        select, textarea, input[type="submit"] { margin-top: 5px; }
    </style>
</head>
<body>

    <h1>Pedidos Pendentes</h1>

    <?php if (empty($pedidos)): ?>
        <p>Nenhum pedido pendente no momento.</p>
    <?php else: ?>
        <?php foreach ($pedidos as $pedido): ?>
            <div class="pedido">
                <h3>Pedido #<?= $pedido['id'] ?> - Cliente: <?= htmlspecialchars($pedido['cliente']) ?></h3>
                <p><strong>Data:</strong> <?= $pedido['data_pedido'] ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($pedido['status']) ?></p>
                <p><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.') ?></p>

                <h4>Itens:</h4>
                <ul>
                    <?php foreach ($pedido['itens'] as $item): ?>
                        <li>
                            <?= htmlspecialchars($item['nome']) ?> - Qtde: <?= $item['quantidade'] ?> - R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?>
                            <?php if(!empty($item['observacao'])): ?>
                                <br><small>Obs: <?= htmlspecialchars($item['observacao']) ?></small>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <form method="POST" action="?rota=atualizar_pedido">
                    <input type="hidden" name="id" value="<?= $pedido['id'] ?>" />

                    <label for="status_<?= $pedido['id'] ?>">Atualizar Status:</label>
                    <select name="status" id="status_<?= $pedido['id'] ?>">
                        <option value="pendente" <?= $pedido['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="em andamento" <?= $pedido['status'] === 'em andamento' ? 'selected' : '' ?>>Em Andamento</option>
                        <option value="finalizado" <?= $pedido['status'] === 'finalizado' ? 'selected' : '' ?>>Finalizado</option>
                        <option value="cancelado" <?= $pedido['status'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>

                    <label for="resposta_admin_<?= $pedido['id'] ?>">Resposta ao Cliente:</label>
                    <textarea name="resposta_admin" id="resposta_admin_<?= $pedido['id'] ?>" placeholder="Digite uma resposta para o cliente..."><?= htmlspecialchars($pedido['resposta_admin'] ?? '') ?></textarea>

                    <input type="submit" value="Salvar Alterações" />
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
