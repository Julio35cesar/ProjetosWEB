<?php

class AdicionarPratoController
{
    public function index()
    {
        $msg = '';
        $erro = false;

        // Valores padrão para manter no form
        $nome = '';
        $descricao = '';
        $preco = '';
        $categoria = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $preco = $_POST['preco'] ?? '';
            $categoria = $_POST['categoria'] ?? '';
            $imagem = $_FILES['imagem'] ?? null;

            // Validações básicas
            if ($nome === '' || $descricao === '' || $categoria === '' || !is_numeric($preco) || floatval($preco) <= 0) {
                $msg = 'Preencha todos os campos corretamente e insira um preço válido maior que zero.';
                $erro = true;
            } else {
                // Upload da imagem, se enviada
                $caminhoImagem = '';
                if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
                    $extPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array($ext, $extPermitidas)) {
                        if (!is_dir('public/imagens')) {
                            mkdir('public/imagens', 0777, true);
                        }
                        $nomeImagem = uniqid('prato_') . '.' . $ext;
                        $destino = 'public/imagens/' . $nomeImagem;
                        if (move_uploaded_file($imagem['tmp_name'], $destino)) {
                            $caminhoImagem = $destino;
                        } else {
                            $msg = 'Erro ao mover a imagem enviada.';
                            $erro = true;
                        }
                    } else {
                        $msg = 'Formato da imagem não permitido. Use JPG, PNG ou GIF.';
                        $erro = true;
                    }
                }

                // Se não houve erro no upload
                if (!$erro) {
                    $prato = new Prato();
                    $resultado = $prato->inserir([
                        'nome' => $nome,
                        'descricao' => $descricao,
                        'preco' => floatval($preco),
                        'categoria' => $categoria,
                        'imagem' => $caminhoImagem
                    ]);

                    if ($resultado) {
                        // Redireciona para o painel admin com sucesso
                        header('Location: ?rota=admin&msg=Prato+adicionado+com+sucesso');
                        exit;
                    } else {
                        $msg = 'Erro ao salvar o prato no banco de dados.';
                        $erro = true;
                    }
                }
            }
        }

        // Inclui a view e passa as variáveis necessárias para manter o estado e mensagens
        include 'view/adicionar.view.php';
    }
}
