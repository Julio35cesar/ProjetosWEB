<?php
require_once 'DB.php';

class Prato {

    // Lista todos os pratos com seus dados
    public static function listarTodos() {
        $db = DB::conectar();
        $sql = "SELECT * FROM pratos ORDER BY nome ASC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Adiciona um novo prato ao banco
    public static function adicionar($nome, $descricao, $preco, $imagem, $categoria) {
        $db = DB::conectar();
        $sql = "INSERT INTO pratos (nome, descricao, preco, imagem, categoria) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$nome, $descricao, $preco, $imagem, $categoria]);
    }

    // Edita um prato já existente
    public static function editar($id, $nome, $descricao, $preco, $categoria, $imagem = null) {
        $db = DB::conectar();

        if ($imagem) {
            $sql = "UPDATE pratos SET nome=?, descricao=?, preco=?, categoria=?, imagem=? WHERE id=?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $categoria, $imagem, $id]);
        } else {
            $sql = "UPDATE pratos SET nome=?, descricao=?, preco=?, categoria=? WHERE id=?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $categoria, $id]);
        }
    }

    // Exclui um prato pelo ID
    public static function excluir($id) {
        $db = DB::conectar();
        $stmt = $db->prepare("DELETE FROM pratos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Busca um prato específico pelo ID
    public static function buscarPorId($id) {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT * FROM pratos WHERE id = ?");
        $stmt->execute($id);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Busca múltiplos pratos por um array de IDs
    public static function buscarPorIds($ids) {
        if (empty($ids)) return [];

        $db = DB::conectar();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM pratos WHERE id IN ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($ids);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
