<?php
session_start();

require_once 'controller/PratoController.php';
require_once 'controller/LoginController.php';

$rota = $_GET['rota'] ?? 'lista';

if ($rota === 'admin' && !isset($_SESSION['usuario'])) {
    header('Location: ?rota=login');
    exit;
}

switch ($rota) {
    case 'lista':
        PratoController::listar();
        break;
    case 'admin':
        PratoController::admin();
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
    default:
        echo "Página não encontrada";
}
