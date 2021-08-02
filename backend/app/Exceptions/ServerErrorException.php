<?php

namespace App\Exceptions;

use App\Services\Common\Response\Code;
use App\Services\Common\Response\Status;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ServerErrorException extends Exception
{
    /**
     * InvalidInputException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = Status::HTTP_INTERNAL_SERVER_ERROR, $code = Code::HTTP_INTERNAL_SERVER_ERROR, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request)
    {
        return response()->json(
            [
                'success' => false,
                'message' => Status::HTTP_INTERNAL_SERVER_ERROR,
                'data' => null
            ],
            $this->code
        );
    }
}