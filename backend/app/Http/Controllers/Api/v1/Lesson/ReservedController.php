<?php

namespace App\Http\Controllers\Api\v1\Lesson;

use App\Http\Controllers\BaseController;
use App\Services\Api\Lesson\LessonReserveApiService;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Support\Facades\Log;

class ReservedController extends BaseController
{
    /**
     * @param LessonReserveApiService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LessonReserveApiService $service)
    {
        try {
            $response = $service->getReservedLessonsCount();
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