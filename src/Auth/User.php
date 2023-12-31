<?php

namespace PHPPatterns\Auth;

use PHPPatterns\Database\DB;

class User
{
    static function exists(string $email): bool
    {
        $result = sql("SELECT * FROM users where email=:email;", ['email' => $email]);

        return $result->rowCount() > 0;
    }

    static function save(array $data)
    {
        $result = sql(
            "INSERT INTO users (email,password,verified,role_id) VALUES (:email,:password,:verified,:role_id);",
            [
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':verified' => $data['verified'],
                ':role_id' => $data['role_id'],
            ]
        );

        return intval(connect()->lastInsertId());
    }
}
