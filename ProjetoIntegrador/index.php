<?php
// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Rota recebida via GET ou padrão "/"
$rota = $_GET['rota'] ?? '/';

// Caminho base dos controllers
$baseController = 'controllers/';

// Roteamento
if ($rota === '/') {
    require $baseController . 'inicio.controller.php';
    $controller = new InicioController();
    $controller->mostrar();
}

else if ($rota === 'cardapio') {
    echo "Página do cardápio em desenvolvimento!";
}

else if ($rota === 'pedido') {
    echo "Página de pedido em desenvolvimento!";
}

else if ($rota === 'admin/login') {
    echo "Área administrativa - Login em desenvolvimento!";
}

else {
    echo "Página não encontrada!";
}
