<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\v1\Auth\LoginFormRequest;
use App\Services\Api\Auth\AuthService;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LoginController extends BaseController
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
     * @param LoginFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginFormRequest $request)
    {
        try {
            $response = $this->authService->login(
                $request->get('email'),
                $request->get('password')
            );

            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (UnauthorizedException $e) {
            Log::info($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::UNAUTHORIZED => $e->getMessage()]))
                ->setMessage($e->getMessage())
                ->setSuccess(false)
                ->setCode($e->getCode())
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setMessage(Status::HTTP_INTERNAL_SERVER_ERROR)
                ->setSuccess(false)
                ->setCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->build();
        }
    }
}
