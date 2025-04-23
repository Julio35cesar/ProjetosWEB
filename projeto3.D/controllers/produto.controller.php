<?php
require 'database.php';
require 'models/Produtos.php';

$query = $pdo->query('SELECT * FROM produtos');
$dados = $query->fetchAll(PDO::FETCH_ASSOC);

// Transforma cada item em um objeto Produto
$produtos = array_map(fn($item) => Produto::make($item), $dados);

view('produtos', ['produtos' => $produtos]);
