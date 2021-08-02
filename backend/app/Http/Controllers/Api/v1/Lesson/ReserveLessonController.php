<?php

namespace App\Http\Controllers\Api\v1\Lesson;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\v1\Lesson\LessonReserveApiRequest;
use App\Http\Requests\Api\v1\Lesson\LessonReserveIndexApiRequest;
use App\Services\Api\Lesson\LessonReserveApiService;
use App\Services\Response\Error;
use App\Services\Response\MessageHelper;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ReserveLessonController extends BaseController
{
    protected LessonReserveApiService $lessonReserveApiService;

    /**
     * ReserveController constructor.
     * @param LessonReserveApiService $lessonReserveApiService
     */
    public function __construct(LessonReserveApiService $lessonReserveApiService)
    {
        $this->lessonReserveApiService = $lessonReserveApiService;
    }

    /**
     * @param LessonReserveIndexApiRequest $lessonReserveIndexApiRequest
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function index(LessonReserveIndexApiRequest $lessonReserveIndexApiRequest): ?\Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->lessonReserveApiService->getReservedLessons($lessonReserveIndexApiRequest);

            return $this->respBuilder()
                ->setData($response)
                ->setSuccess(true)
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
     * @param LessonReserveApiRequest $lessonReserveApiRequest
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function store(LessonReserveApiRequest $lessonReserveApiRequest): ?\Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->lessonReserveApiService->reserveLesson($lessonReserveApiRequest);

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

    public function show()
    {
        try {
            $response = $this->lessonReserveApiService->showReservedLessonInformation();

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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function update(int $id)
    {
        try {
            $response = $this->lessonReserveApiService->confirmReservedLesson($id);
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (ForbiddenException $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::FORBIDDEN => $e->getMessage()]))
                ->setSuccess(false)
                ->setMessage(MessageHelper::ACCESS_NOT_PROVIDED)
                ->setCode(Response::HTTP_FORBIDDEN)
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function destroy(int $id)
    {
        try {
            $response = $this->lessonReserveApiService->revokeReservedLesson($id);

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