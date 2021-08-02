<?php

namespace App\Services\Response;

/**
 * Class Status
 * @package App\Services\Response
 *
 * @author Artyom Kostyukevich, a.kostukevich@iqeon.com
 */
class Status
{
    /**
     * The request was successful. All the operations that should have been performed
     * were completed successfully.
     */
    public const SUCCESS = 'success';

    /**
     * The request was made with an error.
     */
    public const FAILURE = 'failure';

    /**
     * Should be used in case the access to the resource is denied.
     */
    public const FORBIDDEN = 'forbidden';

    public const ACCESS_NOT_PROVIDED = 'access not provided';

    /**
     * Should be used in case the access to the resource is denied.
     */
    public const UNAUTHORIZED = 'unauthorized';

    public const UNPROCESSABLE_ENTITY = 'unprocessable entity';

    public const HTTP_INTERNAL_SERVER_ERROR = 'server error';
}
