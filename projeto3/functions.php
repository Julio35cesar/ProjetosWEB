<?php

// Função para carregar uma view e passar dados para ela

function view($view, $data = []){
    foreach($data as $key => $value){
        $$key = $value;
    }

// Carrega o layout principal do site
    require "views/template/app.php";

}
// Exibe o conteúdo das variáveis passadas com var_dump() formatado e encerra a execução
function dd(...$dump){
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';

    die();
}
// Função que exibe uma página de erro com o código HTTP fornecido (ex: 404)
function abort($code){

    http_response_code(404);
    view($code);
    die();
}

?>