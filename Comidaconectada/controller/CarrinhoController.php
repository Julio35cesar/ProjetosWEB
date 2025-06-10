<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'model/Prato.php';
require_once 'model/DB.php';

class CarrinhoController {
    // Adiciona um prato ao carrinho (sessão)
    public static function adicionar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            echo "<p class='text-red-600'>ID do prato inválido ou não informado.</p>";
            return;
        }

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Incrementa quantidade ou adiciona novo prato
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]++;
        } else {
            $_SESSION['carrinho'][$id] = 1;
        }

        header('Location: ?rota=lista');
        exit;
    }

    // Exibe os pratos adicionados ao carrinho
    public static function verCarrinho() {
        $carrinho = $_SESSION['carrinho'] ?? [];
        $ids = array_keys($carrinho);

        $pratos = [];

        if (!empty($ids)) {
            $pratos = Prato::buscarPorIds($ids);
        }

        require 'view/carrinho.view.php';
    }

    // Remove um prato do carrinho
    public static function remover() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id && isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }

        header('Location: ?rota=carrinho');
        exit;
    }

    // Finaliza o pedido e salva no banco de dados
    public static function finalizar() {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?rota=login');
            exit;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];
        if (empty($carrinho)) {
            echo "<p class='text-red-600 text-center mt-10'>Seu carrinho está vazio.</p>";
            echo "<div class='text-center mt-4'><a href='?rota=lista' class='text-blue-500 underline'>Voltar ao cardápio</a></div>";
            return;
        }

        $db = DB::conectar();

        // Busca os dados dos pratos no carrinho
        $pratos = Prato::buscarPorIds(array_keys($carrinho));

        // Calcula o total do pedido
        $total = 0;
        foreach ($pratos as $prato) {
            $quantidade = $carrinho[$prato['id']];
            $total += $prato['preco'] * $quantidade;
        }

        try {
            // Inicia transação
            $db->beginTransaction();

            // Insere o pedido na tabela 'pedidos'
            $stmt = $db->prepare("INSERT INTO pedidos (usuario_id, total, status, data_pedido) VALUES (?, ?, 'finalizado', datetime('now'))");
            $stmt->execute([$_SESSION['usuario_id'], $total]);
            $pedido_id = $db->lastInsertId();

            // Insere cada item do pedido na tabela 'itens_pedido'
            $stmtItem = $db->prepare("INSERT INTO itens_pedido (pedido_id, prato_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
            foreach ($pratos as $prato) {
                $id = $prato['id'];
                $quantidade = $carrinho[$id];
                $preco = $prato['preco'];
                $stmtItem->execute([$pedido_id, $id, $quantidade, $preco]);
            }

            // Confirma a transação
            $db->commit();

            // Limpa o carrinho após finalizar o pedido
            unset($_SESSION['carrinho']);

            echo "<h2 class='text-green-600 text-xl text-center mt-10'>Pedido realizado com sucesso!</h2>";
            echo "<div class='text-center mt-4'><a href='?rota=lista' class='text-blue-500 underline'>Voltar ao cardápio</a></div>";
        } catch (Exception $e) {
            $db->rollBack();
            echo "<p class='text-red-600 text-center mt-10'>Erro ao finalizar o pedido: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<div class='text-center mt-4'><a href='?rota=carrinho' class='text-blue-500 underline'>Voltar ao carrinho</a></div>";
        }
    }
}
