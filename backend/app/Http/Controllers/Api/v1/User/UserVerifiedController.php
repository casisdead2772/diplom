<?php


namespace App\Http\Controllers\Api\v1\User;


use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\v1\User\UpdateUser;
use App\Services\Api\Auth\AuthService;
use App\Services\Api\User\UserApiService;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserVerifiedController extends BaseController
{
    /**
     * @var UserApiService
     * @var AuthService
     */
    protected AuthService $authService;
    protected UserApiService $userApiService;

    public function __construct(UserApiService $userApiService, AuthService $authService)
    {
        $this->userApiService = $userApiService;
        $this->authService = $authService;
    }

    public function update(int $id)
    {
        try {
            $response = $this->userApiService->updateVerifiedUserInfo($id);
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
