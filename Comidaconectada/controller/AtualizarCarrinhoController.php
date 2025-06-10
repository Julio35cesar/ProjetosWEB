<?php
class AtualizarCarrinhoController
{
    public static function atualizar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Garante que o carrinho está na sessão
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Recebe arrays do formulário
        $quantidades = $_POST['quantidade'] ?? [];
        $observacoes = $_POST['observacao'] ?? [];

        foreach ($quantidades as $id => $qtd) {
            $id = (int)$id;
            $qtd = (int)$qtd;

            // Sanitize observação correspondente
            $obs = isset($observacoes[$id]) ? filter_var($observacoes[$id], FILTER_SANITIZE_STRING) : '';

            if ($qtd < 1) {
                // Se quantidade inválida ou zero, remove do carrinho
                unset($_SESSION['carrinho'][$id]);
            } else {
                // Atualiza ou adiciona o item com quantidade e observação
                $_SESSION['carrinho'][$id] = [
                    'quantidade' => $qtd,
                    'observacao' => $obs
                ];
            }
        }

        // Redireciona de volta ao carrinho
        header('Location: ?rota=carrinho');
        exit;
    }
}
