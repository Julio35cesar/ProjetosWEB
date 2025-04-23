<?php

class Produto
{
    public $id;
    public $nome;
    public $preco;
    public $descricao;

    public static function make($item)
    {
        $produto = new Produto();
        $produto->id = $item['id'];
        $produto->nome = $item['nome'];
        $produto->preco = $item['preco'];
        $produto->descricao = $item['descricao'];
        return $produto;
    }
}
