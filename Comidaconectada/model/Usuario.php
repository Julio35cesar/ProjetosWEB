<?php
require_once __DIR__ . '/DB.php';

class Usuario {
    public static function autenticar($email, $senha) {
        $db = DB::conectar();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }

        return false;
    }
}
