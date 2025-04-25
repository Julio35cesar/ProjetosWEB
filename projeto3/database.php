<?php

class DB
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('sqlite:database.sqlite');
    }

    public function query($query, $class = null, $params = []){
        $prepare = $this->db->prepare($query);

        if($class){
            $prepare->setFetchMode(PDO::FETCH_CLASS, $class);

        }
        $prepare->execute($params);
        return $prepare;
    }
}
// Classe DB: responsável pela conexão com o banco de dados SQLite e execução de querys
// Fornece suporte a consultas com ou sem mapeamento para classes (usando PDO::FETCH_CLASS)

