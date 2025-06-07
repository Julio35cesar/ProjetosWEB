<?php
require_once __DIR__ . '/../model/Usuario.php';

class LoginController
{
    // Exibe o formulário de login
    public static function mostrarFormulario()
    {
        require __DIR__ . '/../view/login.view.php';
    }

    // Processa o login enviado pelo formulário
    public static function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        // Tenta autenticar o usuário
        $user = Usuario::autenticar($email, $senha);

        if ($user) {
            // Armazena dados do usuário na sessão
            $_SESSION['usuario'] = $user['email'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['tipo'] = $user['tipo'] ?? 'cliente';

            // Redireciona conforme tipo do usuário
            if ($_SESSION['tipo'] === 'admin') {
                header('Location: ?rota=admin');
            } else {
                header('Location: ?rota=lista');
            }
            exit;
        } else {
            // Login inválido: mostra mensagem de erro no formulário
            $erro = "Usuário ou senha inválidos";
            require __DIR__ . '/../view/login.view.php';
        }
    }

    // Finaliza a sessão do usuário (logout)
    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: ?rota=lista');
        exit;
    }
}
