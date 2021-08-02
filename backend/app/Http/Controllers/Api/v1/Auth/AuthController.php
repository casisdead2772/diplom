<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\BaseController;
use App\Services\Api\Auth\AuthService;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class AuthController
 * @package App\Http\Controllers
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
class AuthController extends BaseController
{
    /**
     * @var AuthService
     */
    protected AuthService $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): \Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->authService->getUserInfo();
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \JsonException
     */
    public function refreshToken(): \Illuminate\Http\JsonResponse
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->authService->logout();
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

}
