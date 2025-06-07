<?php
require_once __DIR__ . '/DB.php';

class Pedido {

    /**
     * Cria um novo pedido e retorna o ID gerado
     * @param int $id_usuario
     * @param string $data Data do pedido (formato Y-m-d H:i:s)
     * @param string $status Status do pedido (ex: 'pendente', 'finalizado')
     * @param float $total Valor total do pedido
     * @return int ID do pedido criado
     */
    public static function criar(int $id_usuario, string $data, string $status, float $total): int {
        $db = DB::conectar();
        $stmt = $db->prepare("INSERT INTO pedido (id_usuario, data_pedido, status, total) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_usuario, $data, $status, $total]);
        return (int) $db->lastInsertId();
    }

    /**
     * Adiciona um item ao pedido
     * @param int $id_pedido
     * @param int $id_prato
     * @param int $quantidade
     * @param string $observacao
     * @param float $preco_unitario
     * @return bool True se sucesso, false caso contrário
     */
    public static function adicionarItem(int $id_pedido, int $id_prato, int $quantidade, string $observacao, float $preco_unitario): bool {
        $db = DB::conectar();
        $stmt = $db->prepare("INSERT INTO itens_pedido (id_pedido, id_prato, quantidade, observacao, preco_unitario) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id_pedido, $id_prato, $quantidade, $observacao, $preco_unitario]);
    }

    /**
     * Busca todos os pedidos feitos por um usuário específico
     * @param int $id_usuario
     * @return array Lista de pedidos
     */
    public static function buscarPorUsuario(int $id_usuario): array {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT * FROM pedido WHERE id_usuario = ? ORDER BY data_pedido DESC");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista todos os pedidos com nome do cliente (para admin)
     * @return array Lista de pedidos com dados do cliente
     */
    public static function listarTodos(): array {
        $db = DB::conectar();
        $stmt = $db->query("
            SELECT p.*, u.nome AS cliente 
            FROM pedido p 
            JOIN usuarios u ON p.id_usuario = u.id 
            ORDER BY p.data_pedido DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista todos os pedidos com seus itens e nome do cliente (para painel admin)
     * @return array Lista de pedidos com itens e dados do cliente
     */
    public static function listarTodosComItensEUsuario(): array {
        $db = DB::conectar();

        $stmt = $db->query("
            SELECT p.*, u.nome AS cliente 
            FROM pedido p 
            JOIN usuarios u ON p.id_usuario = u.id 
            ORDER BY p.data_pedido DESC
        ");
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Adiciona os itens a cada pedido
        foreach ($pedidos as &$pedido) {
            $pedido['itens'] = self::buscarItens($pedido['id']);
        }

        return $pedidos;
    }

    /**
     * Busca os itens de um pedido específico
     * @param int $id_pedido
     * @return array Lista de itens do pedido
     */
    public static function buscarItens(int $id_pedido): array {
        $db = DB::conectar();
        $stmt = $db->prepare("
            SELECT ip.quantidade, ip.observacao, ip.preco_unitario, p.nome 
            FROM itens_pedido ip 
            JOIN pratos p ON ip.id_prato = p.id 
            WHERE ip.id_pedido = ?
        ");
        $stmt->execute([$id_pedido]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza o status do pedido
     * @param int $id
     * @param string $status
     * @return bool
     */
    public static function atualizarStatus(int $id, string $status): bool {
        $db = DB::conectar();
        $stmt = $db->prepare("UPDATE pedido SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Atualiza a resposta do administrador para o pedido
     * @param int $id
     * @param string $resposta
     * @return bool
     */
    public static function atualizarResposta(int $id, string $resposta): bool {
        $db = DB::conectar();
        $stmt = $db->prepare("UPDATE pedido SET resposta_admin = ? WHERE id = ?");
        return $stmt->execute([$resposta, $id]);
    }
}