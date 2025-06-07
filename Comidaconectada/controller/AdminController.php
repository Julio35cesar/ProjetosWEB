<?php
require_once __DIR__ . '/../model/Prato.php';
require_once __DIR__ . '/../model/Pedido.php';

class AdminController {

    /**
     * Exibe o painel administrativo com abas 'pratos' e 'pedidos'
     * @param string $aba Aba ativa (default 'pratos')
     */
    public static function mostrarPainel(string $aba = 'pratos') {
        if ($aba === 'pratos') {
            // Busca todos os pratos para listar no admin
            $pratos = Prato::listarTodos();
            include __DIR__ . '/../view/admin_pratos.php';

        } elseif ($aba === 'pedidos') {
            // Busca todos os pedidos com itens e dados do usuário
            $pedidos = Pedido::listarTodosComItensEUsuario();
            include __DIR__ . '/../view/admin_pedidos.php';

        } else {
            // Caso aba inválida, exibe mensagem simples
            echo "Aba inválida no painel administrativo.";
        }
    }

    /**
     * Atualiza o status de um pedido e redireciona para a aba 'pedidos'
     * @param int $id_pedido ID do pedido
     * @param string $novo_status Novo status (ex: 'em preparo', 'entregue')
     */
    public static function atualizarStatusPedido(int $id_pedido, string $novo_status) {
        $atualizado = Pedido::atualizarStatus($id_pedido, $novo_status);

        if ($atualizado) {
            header('Location: ?rota=admin&aba=pedidos');
            exit;
        } else {
            echo "Falha ao atualizar o status do pedido.";
        }
    }

    /**
     * Atualiza a resposta do administrador para um pedido
     * @param int $id_pedido
     * @param string $resposta
     */
    public static function atualizarRespostaPedido(int $id_pedido, string $resposta) {
        $atualizado = Pedido::atualizarResposta($id_pedido, $resposta);

        if ($atualizado) {
            header('Location: ?rota=admin&aba=pedidos');
            exit;
        } else {
            echo "Falha ao atualizar a resposta do pedido.";
        }
    }
}
