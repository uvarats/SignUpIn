<?php

namespace App;

class Json
{
    private function __construct()
    {
    }

    public static function encode(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT |
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES |
            JSON_NUMERIC_CHECK);
    }
}
