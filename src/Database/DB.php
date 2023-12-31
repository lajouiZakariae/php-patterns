<?php

namespace PHPPatterns\Database;

use PDOStatement;

class DB
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        try {
            self::$pdo = new \PDO('mysql:hostname=localhost;dbname=auth_system;', 'root', '');
            self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    static function sql($q, ?array $args = null): \PDOStatement
    {
        if (is_null(self::$pdo)) self::connect();

        $q = trim($q);

        $stm = self::$pdo->prepare($q);

        $stm->execute($args);

        return $stm;
    }
}
