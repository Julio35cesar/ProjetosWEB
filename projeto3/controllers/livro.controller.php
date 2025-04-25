<?php
// Busca um livro específico pelo ID vindo da requisição e retorna como objeto da classe Livro
$livro = (new DB)->query(
    'SELECT * FROM livros WHERE id = :id',
    Livro::class,
    ['id' => $_REQUEST['id']]
)->fetch();
// Carrega a view 'livro' e envia o objeto $livro para ela
view('livro', ['livro' => $livro]);

?>