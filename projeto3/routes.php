<?php


//sub a / por nada 
// Obtém apenas o caminho da URL acessada (sem query strings)
$controller = str_replace('/', '', parse_url($_SERVER['REQUEST_URI'])['path']);
//Caso não tenha algum controller especifico e para por o index
if(!$controller) $controller = 'index';

//Caso não exista o controller pedido e para dar abort(erro404)
if(!file_exists("controllers/{$controller}.controller.php")){
    abort(404);
}


//Carrega a controller correspondente a rota atual
require "controllers/{$controller}.controller.php";
