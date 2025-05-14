<?php

class DB {
    private $pdo;

    public function __construct($config) {
        try {
            $this->pdo = new PDO($config['driver'] . ':' . $config['database']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
        }
    }

    public function query($sql) {
        return $this->pdo->query($sql);
    }

    public function inserirPrato($nome, $descricao, $preco, $imagem, $personalizacao, $categoria) {
        $sql = "INSERT INTO pratos (nome, descricao, preco, imagem, personalizacao, categoria) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $descricao, $preco, $imagem, $personalizacao, $categoria]);
    }

    public function getPratos() {
        $sql = "SELECT * FROM pratos";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
