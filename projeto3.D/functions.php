<?php

function view($view, $data = []){

    foreach($data as $key => $value){
        $$key = $value;
    }

    require "views/template/app.php";

}

function dd(...$dump){
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';

    die();
}

function abort($code){

    http_response_code(404);
    view($code);
    die();
}

?>