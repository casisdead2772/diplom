<?php

namespace App\Http\Controllers\Api\v1\Teacher;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\v1\Teacher\TeacherListRequest;
use App\Services\Api\Teacher\TeacherApiService;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeacherController extends BaseController
{
    /**
     * @param TeacherListRequest $request
     * @param TeacherApiService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(TeacherListRequest $request, TeacherApiService $service)
    {
        try {
            $response = $service->getTeacherList($request);
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Code::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

    public function getTeachers(TeacherApiService $service, Request $request)
    {
        try {
            $response = $service->getAllTeacherList($request);
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Code::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }
}
