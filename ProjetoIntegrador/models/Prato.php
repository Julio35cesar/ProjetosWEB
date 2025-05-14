<?php

class Prato
{
    public $id;
    public $nome;
    public $descricao;
    public $preco;
    public $imagem;

    // Construtor
    public function __construct($id, $nome, $descricao, $preco, $imagem)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
    }
}
