<?php

namespace PHPPatterns\Auth;

use PHPPatterns\Database\DB;

class EmailVerificationRequest
{
    public static function save(int $user_id)
    {
        $hash = password_hash(random_bytes(8), PASSWORD_DEFAULT);

        $stm = sql(
            "INSERT INTO requests (user_id,verif_code,timestamp,type) VALUES (?,?,?,?);",
            [$user_id, $hash, time(), 0]
        );

        return [
            "id" => connect()->lastInsertId(),
            "verif_code" => $hash
        ];
    }
}
