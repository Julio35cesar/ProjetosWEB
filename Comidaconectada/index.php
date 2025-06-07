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
require_once 'controller/PedidoController.php';

// Define a rota atual (padrão: 'lista')
$rota = $_GET['rota'] ?? 'lista';

// Lista de rotas válidas do sistema (adicionei 'formAdicionar' aqui)
$rotasValidas = [
    'lista',
    'admin',
    'salvar',
    'excluir',
    'formEditar',
    'formAdicionar',      // Rota para mostrar formulário de adicionar prato
    'editar',
    'login',
    'logout',
    'cadastro',
    'adicionarCarrinho',
    'carrinho',
    'removerCarrinho',
    'finalizarPedido',
    'meus_pedidos',
    'pedidos_admin',
    'responder_pedido'
];

// Redireciona para a página inicial se rota for inválida
if (!in_array($rota, $rotasValidas)) {
    header('Location: ?rota=lista');
    exit;
}

// Rotas que exigem autenticação de administrador (adicionei 'formAdicionar')
$rotasAdmin = [
    'admin',
    'salvar',
    'excluir',
    'editar',
    'formEditar',
    'formAdicionar',      // Só admin pode acessar o formulário para adicionar prato
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

// Define o header UTF-8 (boa prática)
header('Content-Type: text/html; charset=utf-8');

// Roteador de ações
switch ($rota) {

    // Página principal (cardápio)
    case 'lista':
        PratoController::listar();
        break;

    // Área administrativa
    case 'admin':
        PratoController::admin();
        break;

    // Formulário para adicionar prato
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

    // Login e logout
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

    // Cadastro de novo usuário
    case 'cadastro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CadastroController::cadastrar();
        } else {
            CadastroController::mostrarFormulario();
        }
        break;

    // Carrinho de compras
    case 'adicionarCarrinho':
        CarrinhoController::adicionar();
        break;

    case 'carrinho':
        CarrinhoController::verCarrinho();
        break;

    case 'removerCarrinho':
        CarrinhoController::remover();
        break;

    // Pedidos
    case 'finalizarPedido':
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
        
    case 'atualizar_carrinho':
        AtualizarCarrinhoController::atualizar();
        break;


    default:
        echo "Página não encontrada.";
        break;
}
