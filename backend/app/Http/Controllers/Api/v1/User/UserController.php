<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\BaseController;
use App\Services\Api\Auth\AuthService;
use App\Http\Requests\Api\v1\User\UpdateUser;
use App\Http\Resource\Api\User\UserResource;
use App\Services\Api\User\UserApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Response\Error;
use App\Services\Response\Code;
use App\Services\Response\Status;
use App\Entities\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends BaseController
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
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response = $this->userApiService->getUserInfo();
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }


    public function update(UpdateUser $updateUser, int $id)
    {
        try {
            $response = $this->userApiService->updateUserInfo($updateUser, $id);
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
