<?php 

$produto = (new DB)->query(
    'SELECT * FROM produtos WHERE id = :id',
    Produto::class,
    ´['id' => $_REQUEST['id']]
    )->fetch();


    ?>