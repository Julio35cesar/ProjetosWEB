<?php
require_once 'model/Prato.php';

class PratoController {

    // Exibe a página do admin com todos os pratos
    public static function admin() {
        $pratos = Prato::listar();
        include 'view/admin.view.php';
    }

    // Exibe formulário de edição preenchido
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
        include 'view/editar.view.php';
    }

    // Salva um novo prato (inserção)
    public static function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $imagem = null;

            // Upload da imagem
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['imagem']['tmp_name'];
                $originalName = basename($_FILES['imagem']['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $allowed = ['jpg','jpeg','png','gif'];

                if (in_array(strtolower($ext), $allowed)) {
                    $novoNome = uniqid() . '.' . $ext;
                    $destino = 'public/imagens/' . $novoNome;
                    if (move_uploaded_file($tmpName, $destino)) {
                        $imagem = $novoNome;
                    }
                }
            }

            Prato::adicionar($nome, $descricao, $preco, $imagem);
        }
        header('Location: ?rota=admin');
        exit;
    }

    // Exclui um prato pelo id
    public static function excluir() {
        if (!isset($_GET['id'])) {
            header('Location: ?rota=admin');
            exit;
        }
        $id = intval($_GET['id']);

        // Antes de excluir, tenta remover imagem do prato (se existir)
        $prato = Prato::buscarPorId($id);
        if ($prato && $prato['imagem']) {
            $caminhoImagem = 'public/imagens/' . $prato['imagem'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }

        Prato::excluir($id);
        header('Location: ?rota=admin');
        exit;
    }

    // Edita um prato existente
    public static function editar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $nome = $_POST['nome'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $preco = floatval($_POST['preco'] ?? 0);
            $imagem = null;

            // Upload de nova imagem, se enviada
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['imagem']['tmp_name'];
                $originalName = basename($_FILES['imagem']['name']);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $allowed = ['jpg','jpeg','png','gif'];

                if (in_array(strtolower($ext), $allowed)) {
                    $novoNome = uniqid() . '.' . $ext;
                    $destino = 'public/imagens/' . $novoNome;
                    if (move_uploaded_file($tmpName, $destino)) {
                        $imagem = $novoNome;

                        // Apagar imagem antiga
                        $pratoAntigo = Prato::buscarPorId($id);
                        if ($pratoAntigo && $pratoAntigo['imagem']) {
                            $caminhoImagemAntiga = 'public/imagens/' . $pratoAntigo['imagem'];
                            if (file_exists($caminhoImagemAntiga)) {
                                unlink($caminhoImagemAntiga);
                            }
                        }
                    }
                }
            }

            if ($imagem) {
                Prato::editar($id, $nome, $descricao, $preco, $imagem);
            } else {
                Prato::editar($id, $nome, $descricao, $preco);
            }
        }
        header('Location: ?rota=admin');
        exit;
    }
}
