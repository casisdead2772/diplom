<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

/**
 * Class ApiResponse
 * @package App\Helpers
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
class ApiResponse
{
    const HTTP_OK = Response::HTTP_OK;
    const HTTP_CREATED = Response::HTTP_CREATED;
    const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    const HTTP_NOT_FOUND = Response::HTTP_NOT_FOUND;
    const HTTP_UNPROCESSABLE_ENTITY = Response::HTTP_UNPROCESSABLE_ENTITY;
    const HTTP_INTERNAL_SERVER_ERROR = Response::HTTP_INTERNAL_SERVER_ERROR;

    protected static array $availableCodeList = [
        self::HTTP_OK,
        self::HTTP_CREATED,
        self::HTTP_UNAUTHORIZED,
        self::HTTP_NOT_FOUND,
        self::HTTP_UNPROCESSABLE_ENTITY,
        self::HTTP_INTERNAL_SERVER_ERROR,
    ];

    protected string $message;
    protected int $code;
    protected array $responseData = [];
    protected bool $success;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => $this->success,
            'data' => $this->responseData,
            'message' => $this->message,
        ];

        return response()->json($response, $this->code);
    }

    /**
     * @param array $data
     * @param int $code
     * @param bool $success
     * @return ApiResponse
     */
    public function setResponse(array $data, int $code, bool $success): ApiResponse
    {
        $this->responseData = $data;
        return $this->setMessage($code)->setCode($code)->setSuccess($success);
    }

    /**
     * @param string $code
     * @return ApiResponse
     */
    private function setMessage(string $code): ApiResponse
    {
        $this->message = $this->getMessage($code);
        return $this;
    }

    /**
     * @param int $code
     * @return ApiResponse
     */
    private function setCode(int $code): ApiResponse
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param bool $success
     * @return ApiResponse
     */
    private function setSuccess(bool $success): ApiResponse
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @param int $code
     * @param array $messageData
     * @return string
     */
    private function getMessage(int $code, array $messageData = []): string
    {
        if (empty($this->isCodeAvailable($code))) {
            $code = self::HTTP_NOT_FOUND;
        }

        return Lang::get('message.'.$code, $messageData, 'ru');
    }

    /**
     * @param int $code
     * @return bool
     */
    private function isCodeAvailable(int $code): bool
    {
        if (empty($code)) {
            return false;
        }

        return in_array($code, static::$availableCodeList, true);
    }
}
