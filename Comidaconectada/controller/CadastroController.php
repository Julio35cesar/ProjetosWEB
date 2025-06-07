<?php
require_once __DIR__ . '/../model/Usuario.php';

class CadastroController {

    // Exibe o formulário de cadastro
    public static function mostrarFormulario() {
        require __DIR__ . '/../view/cadastro.view.php';
    }

    // Processa o envio do formulário de cadastro
    public static function cadastrar() {
        // Captura os dados enviados pelo formulário
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirma_senha = $_POST['confirma_senha'] ?? '';

        // Verifica se todos os campos estão preenchidos
        if (empty($nome) || empty($email) || empty($senha) || empty($confirma_senha)) {
            $erro = "Por favor, preencha todos os campos.";
            require __DIR__ . '/../view/cadastro.view.php';
            return;
        }

        // Verifica se as senhas coincidem
        if ($senha !== $confirma_senha) {
            $erro = "As senhas não conferem. Por favor, digite novamente.";
            require __DIR__ . '/../view/cadastro.view.php';
            return;
        }

        // Verifica se o e-mail já está cadastrado
        if (Usuario::existeEmail($email)) {
            $erro = "Este email já está cadastrado.";
            require __DIR__ . '/../view/cadastro.view.php';
            return;
        }

        // Cria o hash seguro da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Tenta cadastrar o usuário no banco de dados
        $sucesso = Usuario::cadastrar($nome, $email, $senhaHash);

        if ($sucesso) {
            // Redireciona para a tela de login com mensagem
            header('Location: ?rota=login&msg=conta_criada');
            exit;
        } else {
            $erro = "Erro ao cadastrar usuário. Tente novamente.";
            require __DIR__ . '/../view/cadastro.view.php';
        }
    }
}
