<?php
require_once __DIR__ . '/../model/Prato.php';

class PratoController {

    // Exibe o painel administrativo com todos os pratos
    public static function admin() {
        $pratos = Prato::listarTodos();
        include __DIR__ . '/../view/admin.view.php';
    }

    // Exibe o formulário para editar um prato existente
    public static function formularioEdicao() {
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

    // Exibe o formulário para adicionar um novo prato
    public static function formularioAdicionar() {
        // Apenas inclui a view do formulário de adicionar prato
        include __DIR__ . '/../view/adicionar.view.php';
    }

    // Salva um novo prato no banco de dados
    public static function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $categoria = $_POST['categoria'] ?? ''; // Categoria do prato
            $imagem = null;

            // Upload da imagem, se enviada
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['imagem']['tmp_name'];
                $originalName = basename($_FILES['imagem']['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $allowed = ['jpg','jpeg','png','gif'];

                if (in_array(strtolower($ext), $allowed)) {
                    $novoNome = uniqid() . '.' . $ext;
                    $destino = __DIR__ . '/../public/imagens/' . $novoNome;
                    if (move_uploaded_file($tmpName, $destino)) {
                        $imagem = $novoNome;
                    }
                }
            }

            // Salva o prato no banco
            Prato::adicionar($nome, $descricao, $preco, $imagem, $categoria);
        }

        // Redireciona para o painel admin após salvar
        header('Location: ?rota=admin');
        exit;
    }

    // Exclui um prato pelo ID
    public static function excluir() {
        if (!isset($_GET['id'])) {
            header('Location: ?rota=admin');
            exit;
        }

        $id = intval($_GET['id']);
        $prato = Prato::buscarPorId($id);

        // Remove imagem associada, se existir
        if ($prato && $prato['imagem']) {
            $caminhoImagem = __DIR__ . '/../public/imagens/' . $prato['imagem'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }

        Prato::excluir($id);

        // Redireciona para o painel admin após exclusão
        header('Location: ?rota=admin');
        exit;
    }

    // Edita os dados de um prato existente
    public static function editar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $categoria = $_POST['categoria'] ?? ''; // Categoria do prato
            $imagem = null;

            // Verifica se nova imagem foi enviada para substituir a antiga
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['imagem']['tmp_name'];
                $originalName = basename($_FILES['imagem']['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $allowed = ['jpg','jpeg','png','gif'];

                if (in_array(strtolower($ext), $allowed)) {
                    $novoNome = uniqid() . '.' . $ext;
                    $destino = __DIR__ . '/../public/imagens/' . $novoNome;
                    if (move_uploaded_file($tmpName, $destino)) {
                        $imagem = $novoNome;

                        // Remove a imagem antiga do prato, se existir
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

            // Atualiza o prato no banco com ou sem nova imagem
            if ($imagem) {
                Prato::editar($id, $nome, $descricao, $preco, $categoria, $imagem);
            } else {
                Prato::editar($id, $nome, $descricao, $preco, $categoria);
            }
        }

        // Redireciona para o painel admin após edição
        header('Location: ?rota=admin');
        exit;
    }

    // Lista os pratos para o público (cardápio)
    public static function listar() {
        $pratos = Prato::listarTodos();
        include __DIR__ . '/../view/index.view.php';
    }
}
