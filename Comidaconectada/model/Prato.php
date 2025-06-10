<?php
require_once 'DB.php';

class Prato {

    /**
     * Lista todos os pratos ordenados por nome
     * @return array
     */
    public static function listarTodos(): array {
        $db = DB::conectar();
        $sql = "SELECT * FROM pratos ORDER BY nome ASC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Adiciona um novo prato
     * @param string $nome
     * @param string $descricao
     * @param float $preco
     * @param string $imagem
     * @param string $categoria
     * @return bool
     */
    public static function adicionar(string $nome, string $descricao, float $preco, string $imagem, string $categoria): bool {
        $db = DB::conectar();
        $sql = "INSERT INTO pratos (nome, descricao, preco, imagem, categoria) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$nome, $descricao, $preco, $imagem, $categoria]);
    }

    /**
     * Edita os dados de um prato existente
     * @param int $id
     * @param string $nome
     * @param string $descricao
     * @param float $preco
     * @param string $categoria
     * @param string|null $imagem
     * @return bool
     */
    public static function editar(int $id, string $nome, string $descricao, float $preco, string $categoria, ?string $imagem = null): bool {
        $db = DB::conectar();

        if ($imagem) {
            $sql = "UPDATE pratos SET nome = ?, descricao = ?, preco = ?, categoria = ?, imagem = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $categoria, $imagem, $id]);
        } else {
            $sql = "UPDATE pratos SET nome = ?, descricao = ?, preco = ?, categoria = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $categoria, $id]);
        }
    }

    /**
     * Exclui um prato pelo ID
     * @param int $id
     * @return bool
     */
    public static function excluir(int $id): bool {
        $db = DB::conectar();
        $stmt = $db->prepare("DELETE FROM pratos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Busca um prato específico pelo ID
     * @param int $id
     * @return array|null
     */
    public static function buscarPorId(int $id): ?array {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT * FROM pratos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Busca múltiplos pratos por array de IDs
     * @param array $ids
     * @return array
     */
    public static function buscarPorIds(array $ids): array {
        if (empty($ids)) return [];

        $db = DB::conectar();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM pratos WHERE id IN ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($ids);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
