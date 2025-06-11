<?php
require_once __DIR__ . '/../model/Prato.php';

class PratoController
{
    // Mostra o painel admin com todos os pratos
    public static function admin()
    {
        $pratos = Prato::listarTodos();
        include __DIR__ . '/../view/admin.view.php';
    }

    // Mostra o formulário para editar prato
    public static function formularioEdicao()
    {
        if (!isset($_GET['id'])) {
            header('Location: ?rota=admin');
            exit;
        }

        $id = intval($_GET['id']);
        $prato = Prato::buscarPorId($id);

        if (!$prato) {
            header('Location: ?rota=admin');
            exit;
        }

        include __DIR__ . '/../view/editar.view.php';
    }

    // Mostra o formulário para adicionar prato
    public static function formularioAdicionar()
    {
        include __DIR__ . '/../view/adicionar.view.php';
    }

    // Salva novo prato no banco
    public static function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $categoria = $_POST['categoria'] ?? '';
            $imagem = null;

            // Upload da imagem, se houver
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['imagem']['tmp_name'];
                $originalName = basename($_FILES['imagem']['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array(strtolower($ext), $allowed)) {
                    $novoNome = uniqid() . '.' . $ext;
                    $destino = __DIR__ . '/../public/imagens/' . $novoNome;
                    if (move_uploaded_file($tmpName, $destino)) {
                        $imagem = $novoNome;
                    }
                }
            }

            // Importante: seu model Prato não tem método estático 'adicionar', 
            // mas sim o método não estático 'inserir' que espera um array.
            $prato = new Prato();
            $dados = [
                'nome' => $nome,
                'descricao' => $descricao,
                'preco' => $preco,
                'categoria' => $categoria,
                'imagem' => $imagem
            ];
            $prato->inserir($dados);
        }

        header('Location: ?rota=admin');
        exit;
    }

    // Exclui prato e sua imagem
    public static function excluir()
    {
        if (!isset($_GET['id'])) {
            header('Location: ?rota=admin');
            exit;
        }

        $id = intval($_GET['id']);
        $prato = Prato::buscarPorId($id);

        if ($prato && $prato['imagem']) {
            $caminhoImagem = __DIR__ . '/../public/imagens/' . $prato['imagem'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }

        Prato::excluir($id);

        header('Location: ?rota=admin');
        exit;
    }

    // Edita prato existente
    public static function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $categoria = $_POST['categoria'] ?? '';
            $imagem = null;

            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['imagem']['tmp_name'];
                $originalName = basename($_FILES['imagem']['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array(strtolower($ext), $allowed)) {
                    $novoNome = uniqid() . '.' . $ext;
                    $destino = __DIR__ . '/../public/imagens/' . $novoNome;
                    if (move_uploaded_file($tmpName, $destino)) {
                        $imagem = $novoNome;

                        // Remove a imagem antiga, se existir
                        $pratoAntigo = Prato::buscarPorId($id);
                        if ($pratoAntigo && $pratoAntigo['imagem']) {
                            $caminhoImagemAntiga = __DIR__ . '/../public/imagens/' . $pratoAntigo['imagem'];
                            if (file_exists($caminhoImagemAntiga)) {
                                unlink($caminhoImagemAntiga);
                            }
                        }
                    }
                }
            }

            // Atualiza prato com ou sem imagem nova
            if ($imagem) {
                Prato::editar($id, $nome, $descricao, $preco, $categoria, $imagem);
            } else {
                Prato::editar($id, $nome, $descricao, $preco, $categoria);
            }
        }

        header('Location: ?rota=admin');
        exit;
    }

    // Lista pratos para público (cardápio)
    public static function listar()
    {
        $pratos = Prato::listarTodos();
        include __DIR__ . '/../view/index.view.php';
    }
}
