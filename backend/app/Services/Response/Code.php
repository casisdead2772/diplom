<?php

namespace App\Services\Response;

class Code
{
    /**
     * The request was successful. All the operations that should have been performed
     * were completed successfully.
     */
    public const SUCCESS = 200;

    /**
     * The request was made with an error.
     */
    public const FAILURE = 500;

    /**
     * Should be used in case the access to the resource is denied.
     */
    public const FORBIDDEN = 403;

    /**
     * Should be used in case the access to the resource is denied.
     */
    public const UNAUTHORIZED = 401;

    public const UNPROCESSABLE_ENTITY = 422;

    public const HTTP_INTERNAL_SERVER_ERROR =  500;
}