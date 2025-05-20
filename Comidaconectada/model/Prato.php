<?php
require_once 'DB.php';

class Prato {
    public static function listar() {
        $db = DB::conectar();
        $sql = "SELECT * FROM pratos";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function adicionar($nome, $descricao, $preco, $imagem) {
        $db = DB::conectar();
        $sql = "INSERT INTO pratos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nome, $descricao, $preco, $imagem]);
    }

    public static function editar($id, $nome, $descricao, $preco, $imagem = null) {
        $db = DB::conectar();
        if ($imagem) {
            $sql = "UPDATE pratos SET nome=?, descricao=?, preco=?, imagem=? WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$nome, $descricao, $preco, $imagem, $id]);
        } else {
            $sql = "UPDATE pratos SET nome=?, descricao=?, preco=? WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$nome, $descricao, $preco, $id]);
        }
    }

    public static function excluir($id) {
        $db = DB::conectar();
        $stmt = $db->prepare("DELETE FROM pratos WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function buscarPorId($id) {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT * FROM pratos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
