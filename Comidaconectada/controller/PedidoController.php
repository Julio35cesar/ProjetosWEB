<?php
require_once __DIR__ . '/../model/Pedido.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../model/Prato.php';

class PedidoController
{
    // Função auxiliar para garantir ID do usuário a partir de ID ou email
    private static function obterIdUsuario($usuarioSessao)
    {
        if (is_int($usuarioSessao)) {
            return $usuarioSessao;
        }

        if (filter_var($usuarioSessao, FILTER_VALIDATE_EMAIL)) {
            $usuario = Usuario::buscarPorEmail($usuarioSessao);
            if ($usuario && isset($usuario['id'])) {
                return $usuario['id'];
            }
        }

        return null; // Não conseguiu identificar usuário válido
    }

    public static function finalizarPedido()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario']) || empty($_SESSION['carrinho'])) {
            header('Location: ?rota=lista');
            exit;
        }

        $id_usuario = self::obterIdUsuario($_SESSION['usuario']);
        if (!$id_usuario) {
            exit("Usuário inválido.");
        }

        $itens = $_SESSION['carrinho'];
        $data = date('Y-m-d H:i:s');
        $total = 0;

        $ids = array_keys($itens);
        $valorPedido = Prato::buscarPorIds($ids);

        foreach ($valorPedido as $item) {
            $id = $item['id'];
            $quantidade = $itens[$id]['quantidade'] ?? 1;
            $total += $item['preco'] * $quantidade;
        }

        if ($total <= 0) {
            header('Location: ?rota=carrinho');
            exit;
        }

        $pedido_id = Pedido::criar($id_usuario, $data, 'finalizado', $total);

        if (!$pedido_id) {
            echo "<p class='text-red-600 text-center mt-10'>Erro ao criar pedido. Tente novamente.</p>";
            echo "<div class='text-center mt-4'><a href='?rota=carrinho' class='text-blue-500 underline'>Voltar ao carrinho</a></div>";
            exit;
        }

        foreach ($itens as $item) {
            $id_prato = $item['id'] ?? null;
            $quantidade = $item['quantidade'] ?? 0;
            $observacao = $item['observacao'] ?? '';
            $preco = $item['preco'] ?? 0;

            if ($id_prato && $quantidade > 0 && $preco > 0) {
                Pedido::adicionarItem($pedido_id, $id_prato, $quantidade, $observacao, $preco);
            }
        }

        unset($_SESSION['carrinho']);
        header("Location: ?rota=meus_pedidos");
        exit;
    }

    public static function meusPedidos()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario'])) {
            header('Location: ?rota=login');
            exit;
        }

        $id_usuario = self::obterIdUsuario($_SESSION['usuario']);
        if (!$id_usuario) {
            exit("Usuário inválido.");
        }

        $pedidos = Pedido::buscarPorUsuario($id_usuario);

        foreach ($pedidos as &$pedido) {
            $pedido['itens'] = Pedido::buscarItens($pedido['id']);
        }

        require __DIR__ . '/../view/pedidos_cliente.view.php';
    }

    public static function listarTodos()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?rota=login');
            exit;
        }

        $pedidos = Pedido::listarTodosComItensEUsuario();

        require __DIR__ . '/../view/pedidos_admin.view.php';
    }

    public static function responder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'pedido_id', FILTER_VALIDATE_INT);
            $novo_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
            $resposta_admin = filter_input(INPUT_POST, 'resposta_admin', FILTER_SANITIZE_STRING);

            if (!$id || !$novo_status) {
                header('Location: ?rota=pedidos_admin');
                exit;
            }

            Pedido::atualizarStatus($id, $novo_status);

            if ($resposta_admin !== null) {
                Pedido::atualizarResposta($id, $resposta_admin);
            }

            header('Location: ?rota=pedidos_admin');
            exit;
        }
    }
}
