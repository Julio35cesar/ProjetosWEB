<?php
require_once __DIR__ . '/DB.php';

class Usuario {

    /**
     * Verifica se o e-mail já está cadastrado no banco.
     * @param string $email
     * @return bool true se existir, false caso contrário.
     */
    public static function existeEmail(string $email): bool {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Cadastra um novo usuário.
     * @param string $nome
     * @param string $email
     * @param string $senhaHash - senha já hashada com password_hash
     * @param string $tipo - 'cliente' ou 'admin' (padrão: 'cliente')
     * @return bool true em caso de sucesso, false em caso de falha
     */
    public static function cadastrar(string $nome, string $email, string $senhaHash, string $tipo = 'cliente'): bool {
        $db = DB::conectar();
        $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nome, $email, $senhaHash, $tipo]);
    }

    /**
     * Autentica usuário pelo e-mail e senha.
     * @param string $email
     * @param string $senha - senha em texto plano
     * @return array|false - dados do usuário se autenticado, false caso contrário
     */
    public static function autenticar(string $email, string $senha) {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']); // Remove senha por segurança
            return $usuario;
        }

        return false;
    }

    /**
     * Busca usuário pelo ID.
     * @param int $id
     * @return array|false - dados do usuário ou false se não encontrado
     */
    public static function buscarPorId(int $id) {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT id, nome, email, tipo FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca usuário pelo e-mail.
     * @param string $email
     * @return array|null - dados do usuário ou null se não encontrado
     */
    public static function buscarPorEmail(string $email): ?array {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT id, nome, email, tipo FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }

    /**
     * Lista todos os usuários (útil para painel admin).
     * @return array - lista de usuários
     */
    public static function listarTodos(): array {
        $db = DB::conectar();
        $stmt = $db->query("SELECT id, nome, email, tipo FROM usuarios ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
