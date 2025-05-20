<?php
class DB {
    public static function conectar() {
        return new PDO("sqlite:banco.sqlite");
    }
}
