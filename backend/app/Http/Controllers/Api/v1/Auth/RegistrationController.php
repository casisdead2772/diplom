<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\v1\Auth\RegistrationFormRequest;
use App\Services\Api\Auth\AuthService;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RegistrationController extends BaseController
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
     * @param RegistrationFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegistrationFormRequest $request)
    {
        try {
            $response = $this->authService->registration($request->getDto());

            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => 'Server error']))
                ->setMessage(Status::HTTP_INTERNAL_SERVER_ERROR)
                ->setSuccess(false)
                ->setCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->build();
        }
    }
}
