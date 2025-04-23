<?php

require 'dados.php';
require 'database.php';

view('index', ['livros' => $livros]);
view('produtos', ['produtos' => $produtos]);
?>