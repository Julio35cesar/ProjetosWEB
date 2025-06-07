<?php
class DB {
    private static $conexao = null;

    public static function conectar() {
        if (self::$conexao === null) {
            try {
                // Ajuste o caminho do arquivo banco.sqlite conforme seu projeto
                self::$conexao = new PDO("sqlite:banco.sqlite");
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }
        return self::$conexao;
    }
}
?>
