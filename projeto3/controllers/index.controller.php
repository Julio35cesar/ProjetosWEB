<?php
// Pega o valor de 'pesquisar', ou usa '' se não estiver definido
$pesquisar = $_REQUEST['pesquisar'] ?? '';
//ao pesquisar vai para o banco de dados e puxa a class que se encaixa na pesquisa
$livros = (new DB)->query(
query: "select * from livros WHERE titulo like 
:pesquisar or autor like :pesquisar 
or descricao like :pesquisar", 
class: Livro::class,
// Define o parâmetro 'pesquisar'  para busca parcial e executa a consulta retornando todos os resultados
params: ['pesquisar' => "%$pesquisar%"])->fetchAll();
// Carrega a view 'index' e envia a variável $livros para ela
view('index', compact('livros'));

