<?php
class DB {
    private static $conexao = null;

    public static function conectar() {
        if (self::$conexao === null) {
            try {
                // Ajuste o caminho para o arquivo banco.sqlite, usando __DIR__ para garantir o caminho absoluto
                $caminhoBanco = __DIR__ . '/../banco.sqlite'; 
                self::$conexao = new PDO("sqlite:" . $caminhoBanco);
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }
        return self::$conexao;
    }
}
?>
