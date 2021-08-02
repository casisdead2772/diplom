<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class BadRequestException extends Exception
{
    private array $errors;

    /**
     * InvalidInputException constructor.
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(array $errors = [], $message = "Bad request.", $code = Response::HTTP_BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
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
                'message' => $this->message,
                'data' => null,
                'errors' => Error::errors($this->errors),
            ],
            $this->code
        );
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
