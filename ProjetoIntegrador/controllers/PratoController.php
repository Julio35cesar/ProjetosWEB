<?php

class PratoController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Pega todos os pratos normalmente
    public function getPratos() {
        $sql = "SELECT * FROM pratos";
        return $this->db->query($sql);
    }

    // Novo método para pegar pratos agrupados por categoria
    public function getPratosAgrupadosPorCategoria() {
        $sql = "SELECT * FROM pratos ORDER BY categoria, nome";
        $result = $this->db->query($sql);

        $categorias = [];

        foreach ($result as $prato) {
            $categoria = $prato['categoria'];

            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = [];
            }

            $categorias[$categoria][] = $prato;
        }

        return $categorias;
    }
}
