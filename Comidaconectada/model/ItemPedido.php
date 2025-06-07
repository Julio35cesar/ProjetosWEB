<?php
require_once __DIR__ . '/DB.php';

class ItemPedido {

    /**
     * Adiciona um item ao pedido especificado.
     * 
     * @param int $id_pedido ID do pedido ao qual o item será associado
     * @param int $id_prato ID do prato que foi pedido
     * @param int $quantidade Quantidade do prato pedido
     * @param string $observacao Observações adicionais do cliente
     * @param float $preco_unitario Preço do prato no momento do pedido
     * @return bool Retorna true se a inserção foi bem-sucedida
     */
    public static function adicionarItem(
        int $id_pedido, 
        int $id_prato, 
        int $quantidade, 
        string $observacao, 
        float $preco_unitario
    ): bool {
        $db = DB::conectar();

        $stmt = $db->prepare("
            INSERT INTO itens_pedido (id_pedido, id_prato, quantidade, observacao, preco_unitario) 
            VALUES (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $id_pedido, 
            $id_prato, 
            $quantidade, 
            $observacao, 
            $preco_unitario
        ]);
    }
}
