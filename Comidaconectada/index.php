<?php
session_start();

// Inclui os arquivos principais dos models
require_once 'model/Usuario.php';
require_once 'model/Prato.php';
require_once 'model/Pedido.php';
require_once 'model/ItemPedido.php';

// Inclui os controllers do sistema
require_once 'controller/PratoController.php';
require_once 'controller/LoginController.php';
require_once 'controller/CadastroController.php';
require_once 'controller/CarrinhoController.php';
require_once 'controller/AtualizarCarrinhoController.php';
require_once 'controller/AdminController.php';
require_once 'controller/PedidoController.php';
require_once 'controller/AdicionarPratoController.php'; // Controller para adicionar pratos

// Obtém a rota da URL, padrão para 'lista' se não existir
$rota = $_GET['rota'] ?? 'lista';

// Lista de rotas válidas do sistema
$rotasValidas = [
    'lista',
    'admin',
    'adicionar',
    'excluir',
    'formEditar',
    'editar',
    'login',
    'logout',
    'cadastro',
    'adicionarCarrinho',
    'carrinho',
    'removerCarrinho',
    'atualizar_carrinho',
    'finalizar_pedido',
    'meus_pedidos',
    'pedidos_admin',
    'responder_pedido'
];

// Se a rota não for válida, redireciona para a lista pública de pratos
if (!in_array($rota, $rotasValidas)) {
    header('Location: ?rota=lista');
    exit;
}

// Rotas que precisam de autenticação de administrador
$rotasAdmin = [
    'adicionar',
    'admin',
    'excluir',
    'editar',
    'formEditar',
    'pedidos_admin',
    'responder_pedido'
];

// Proteção das rotas administrativas
if (in_array($rota, $rotasAdmin)) {
    // Verifica se usuário está logado e se é admin
    if (!isset($_SESSION['usuario']) || ($_SESSION['tipo'] ?? '') !== 'admin') {
        header('Location: ?rota=login');
        exit;
    }
}

// Define o cabeçalho para UTF-8
header('Content-Type: text/html; charset=utf-8');

// Roteador principal que chama o controller conforme a rota
switch ($rota) {
    case 'lista':
        PratoController::listar();
        break;

    case 'admin':
        PratoController::admin();
        break;

    case 'adicionar':
        // Instancia controller para adicionar prato e chama index
        $controller = new AdicionarPratoController();
        $controller->index();
        break;

    case 'excluir':
        PratoController::excluir();
        break;

    case 'formEditar':
        PratoController::formularioEdicao();
        break;

    case 'editar':
        PratoController::editar();
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            LoginController::login();
        } else {
            LoginController::mostrarFormulario();
        }
        break;

    case 'logout':
        LoginController::logout();
        break;

    case 'cadastro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CadastroController::cadastrar();
        } else {
            CadastroController::mostrarFormulario();
        }
        break;

    case 'adicionarCarrinho':
        CarrinhoController::adicionar();
        break;

    case 'carrinho':
        CarrinhoController::verCarrinho();
        break;

    case 'removerCarrinho':
        CarrinhoController::remover();
        break;

    case 'atualizar_carrinho':
        AtualizarCarrinhoController::atualizar();
        break;

    case 'finalizar_pedido':
        PedidoController::finalizarPedido();
        break;

    case 'meus_pedidos':
        PedidoController::meusPedidos();
        break;

    case 'pedidos_admin':
        PedidoController::listarTodos();
        break;

    case 'responder_pedido':
        PedidoController::responder();
        break;

    default:
        echo "<h1>Página não encontrada.</h1>";
        break;
}
