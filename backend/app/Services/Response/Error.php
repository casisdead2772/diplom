<?php

namespace App\Services\Response;

class Error
{
    /**
     * @param array $errors
     * @return array
     */
    public static function errors(array $errors): array
    {
        $response = [];
        foreach ($errors as $key => $value) {
            $response[$key] = [$value];
        }
        return $response;
    }
}
