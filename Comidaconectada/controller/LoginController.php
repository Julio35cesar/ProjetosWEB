<?php
require_once 'model/Usuario.php';

class LoginController {

    public static function mostrarFormulario() {
        include 'view/login.view.php';
    }

    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $user = Usuario::buscarPorUsuario($usuario);

            if ($user && password_verify($senha, $user['senha'])) {
                session_start();
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['nome'] = $user['nome'];
                header('Location: ?rota=admin');
                exit;
            } else {
                $erro = "Usuário ou senha inválidos";
                include 'view/login.view.php';
            }
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        header('Location: ?rota=login');
        exit;
    }
}
