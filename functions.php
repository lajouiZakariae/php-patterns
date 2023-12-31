<?php

try {
    $pdo = new \PDO('mysql:hostname=localhost;dbname=auth_system;', 'root', '');
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
} catch (\Throwable $th) {
    throw $th;
}


function sql($q, ?array $args = null): \PDOStatement
{
    global $pdo;

    $q = trim($q);

    $stm = $pdo->prepare($q);

    $stm->execute($args);

    return $stm;
}
