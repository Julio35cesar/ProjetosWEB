<?php

class Livro
{

    public $id;
    public $titulo;
    public $autor;
    public $descricao;


    public static function make($item)
    {
        $livro = new Livro();
        $livro->id = $item['id'];
        $livro->titulo = $item['titulo'];
        $livro->autor = $item['autor'];
        $livro->descricao = $item['descricao'];
        return $livro;
    }
}
