<?php
session_start();

// Requisições dos arquivos principais
require_once 'model/Usuario.php';
require_once 'model/Prato.php';
require_once 'model/Pedido.php';
require_once 'model/ItemPedido.php';

require_once 'controller/PratoController.php';
require_once 'controller/LoginController.php';
require_once 'controller/CadastroController.php';
require_once 'controller/CarrinhoController.php';
require_once 'controller/AtualizarCarrinhoController.php';
require_once 'controller/AdminController.php';
require_once 'controller/PedidoController.php'; // <-- Certifique-se de ter isso incluído

// Define a rota atual (padrão: 'lista')
$rota = $_GET['rota'] ?? 'lista';

// Lista de rotas válidas do sistema
$rotasValidas = [
    'adicionar',
    'lista',
    'admin',
    'salvar',
    'excluir',
    'formEditar',
    'formAdicionar',
    'editar',
    'login',
    'logout',
    'cadastro',
    'adicionarCarrinho',
    'carrinho',
    'removerCarrinho',
    'atualizar_carrinho',     // <-- Corrigido nome da rota
    'finalizar_pedido',
    'meus_pedidos',
    'pedidos_admin',
    'responder_pedido'
];

// Redireciona para a página inicial se a rota for inválida
if (!in_array($rota, $rotasValidas)) {
    header('Location: ?rota=lista');
    exit;
}

// Rotas que exigem autenticação de administrador
$rotasAdmin = [
    'adicionar',
    'admin',
    'salvar',
    'excluir',
    'editar',
    'formEditar',
    'formAdicionar',
    'pedidos_admin',
    'responder_pedido'
];

// Protege rotas administrativas
if (in_array($rota, $rotasAdmin)) {
    if (!isset($_SESSION['usuario']) || ($_SESSION['tipo'] ?? '') !== 'admin') {
        header('Location: ?rota=login');
        exit;
    }
}

// Define o header UTF-8
header('Content-Type: text/html; charset=utf-8');

// Roteador de ações
switch ($rota) {
    case 'lista':
        PratoController::listar();
        break;

    case 'admin':
        PratoController::admin();
        break;

    case 'formAdicionar':
        PratoController::formularioAdicionar();
        break;

    case 'salvar':
        PratoController::salvar();
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
        echo "Página não encontrada.";
        break;
}
