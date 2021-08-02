<?php

namespace App\Http\Controllers\Api\v1\Teacher;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\v1\Teacher\TeacherAboutStoreRequest;
use App\Services\Api\Teacher\TeacherApiService;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TeacherAboutController extends BaseController
{
    public function __invoke(TeacherAboutStoreRequest $teacherAboutRequest, int $id, TeacherApiService $teacherApiService)
    {
        try {
            $response = $teacherApiService->setTeacherAboutInformation($teacherAboutRequest, $id);

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
