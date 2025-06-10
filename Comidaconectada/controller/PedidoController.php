<?php
require_once __DIR__ . '/../model/Pedido.php';

class PedidoController
{
    /**
     * Finaliza o pedido do cliente logado, salva no banco e limpa o carrinho
     */
    public static function finalizarPedido()
    {


        if (session_status() === PHP_SESSION_NONE) session_start();

        // Verifica se usuário está logado e carrinho não está vazio
        if (!isset($_SESSION['usuario']) || empty($_SESSION['carrinho'])) {
            header('Location: ?rota=lista');
            exit;
        }



        $id_usuario = $_SESSION['usuario'];
        $itens = $_SESSION['carrinho'];
        $data = date('Y-m-d H:i:s');
        $total = 0;
        $ids = array_keys($itens);
        $valorPedido = Prato::buscarPorIds($ids);
        // Calcula o total do pedido
        foreach ($valorPedido as $item) {
            
            $total += $item['preco'];
            
        }


        if ($total <= 0) {
            header('Location: ?rota=carrinho');
            exit;
        }

        // Cria o pedido com status "finalizado"
        $pedido_id = Pedido::criar($id_usuario, $data, 'finalizado', $total);

        if (!$pedido_id) {
            echo "<p class='text-red-600 text-center mt-10'>Erro ao criar pedido. Tente novamente.</p>";
            echo "<div class='text-center mt-4'><a href='?rota=carrinho' class='text-blue-500 underline'>Voltar ao carrinho</a></div>";
            exit;
        }

        // Adiciona os itens do pedido
        foreach ($itens as $item) {
            $id_prato = $item['id'] ?? null;
            $quantidade = $item['quantidade'] ?? 0;
            $observacao = $item['observacao'] ?? '';
            $preco = $item['preco'] ?? 0;

            if (!$id_prato || $quantidade <= 0 || $preco <= 0) continue;

            Pedido::adicionarItem($pedido_id, $id_prato, $quantidade, $observacao, $preco);
        }

        // Limpa o carrinho da sessão
        unset($_SESSION['carrinho']);

        // Redireciona para os pedidos do cliente
        header("Location: ?rota=meus_pedidos");
        exit;
    }

    /**
     * Exibe os pedidos do cliente logado
     */
    public static function meusPedidos()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?rota=login');
            exit;
        }

        // Busca os pedidos do usuário logado
        $pedidos = Pedido::buscarPorUsuario($_SESSION['usuario_id']);

        // Adiciona os itens de cada pedido
        foreach ($pedidos as &$pedido) {
            $pedido['itens'] = Pedido::buscarItens($pedido['id']);
        }

        require __DIR__ . '/../view/pedidos_cliente.view.php';
    }

    /**
     * Exibe todos os pedidos para o painel do administrador
     */
    public static function listarTodos()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Verifica se o usuário é administrador
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?rota=login');
            exit;
        }

        // Lista todos os pedidos com itens e dados do cliente
        $pedidos = Pedido::listarTodosComItensEUsuario();

        require __DIR__ . '/../view/pedidos_admin.view.php';
    }

    /**
     * Atualiza o status e resposta de um pedido (apenas admin)
     */
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

            // Atualiza o status do pedido
            Pedido::atualizarStatus($id, $novo_status);

            // Atualiza a resposta do admin (mensagem para o cliente)
            if ($resposta_admin !== null) {
                Pedido::atualizarResposta($id, $resposta_admin);
            }

            header('Location: ?rota=pedidos_admin');
            exit;
        }
    }
}
