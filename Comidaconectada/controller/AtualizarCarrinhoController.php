<?php
class AtualizarCarrinhoController
{
    public static function atualizar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica se o carrinho existe na sessão
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Espera dados via POST: id do item, nova quantidade e observação
        $id_item = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);

        if ($id_item === false || $quantidade === false || $quantidade < 0) {
            // Dados inválidos - redireciona ou mostra erro
            header('Location: ?rota=carrinho');
            exit;
        }

        // Atualiza ou remove item do carrinho
        if ($quantidade === 0) {
            // Remove o item do carrinho
            if (isset($_SESSION['carrinho'][$id_item])) {
                unset($_SESSION['carrinho'][$id_item]);
            }
        } else {
            // Atualiza quantidade e observação
            if (isset($_SESSION['carrinho'][$id_item])) {
                $_SESSION['carrinho'][$id_item]['quantidade'] = $quantidade;
                $_SESSION['carrinho'][$id_item]['observacao'] = $observacao;
            }
        }

        // Redireciona para a página do carrinho após atualizar
        header('Location: ?rota=carrinho');
        exit;
    }
}
